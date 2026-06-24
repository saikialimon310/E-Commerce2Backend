<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    // ✅ SHOW ALL PRODUCTS
    public function index()
    {
        $products = Product::with(['images', 'category'])
            ->where('user_id', auth()->id())
            ->get();
        return view('products.index', compact('products'));
    }

    // ✅ CREATE PAGE
    public function create()
    {

        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // ✅ STORE PRODUCT
    public function store(Request $request)
    {
        $data = $request->only([
            'category_id',
            'product_name',
            'price',
            'discount',
            'avail_count'
        ]);

        $images = $request->file('images', []);
        $uploadErrors = [];

        if (is_array($images)) {
            foreach ($images as $index => $img) {
                if ($img instanceof UploadedFile && ! $img->isValid()) {
                    $uploadErrors["images.$index"] = $this->uploadErrorMessage($img->getError());
                }
            }
        } elseif ($images instanceof UploadedFile && ! $images->isValid()) {
            $uploadErrors['images.0'] = $this->uploadErrorMessage($images->getError());
        }

        if (! empty($uploadErrors)) {
            return redirect()->back()->withInput()->withErrors($uploadErrors);
        }

        // not used but required column fix
        $data['user_id'] = auth()->id();
        $data['image'] = 'NA';
        $data['booked_count'] = 0;
        $data['status'] = 'hold';
        $data['user_id'] = auth()->id();
        $product = Product::create($data);

        // ✅ MULTIPLE IMAGE UPLOAD
        $images = $request->file('images', []);
        // dd($images);
        if (is_array($images)) {
            // dd("ok");
            foreach ($images as $img) {
                // if (! $img instanceof UploadedFile || ! $img->isValid()) {
                //     continue;
                // }
                // dd("here");
                $path = $this->storeCompressedImage($img, 'products', 30);
                // dd($path);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $path
                ]);
            }
        } elseif ($images instanceof UploadedFile && $images->isValid()) {
            $path = $this->storeCompressedImage($images, 'products', 30);
            ProductImage::create([
                'product_id' => $product->id,
                'image'      => $path
            ]);
        }
        // dd("here1");
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully');
    }

    // ✅ EDIT PAGE
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    // ✅ UPDATE PRODUCT + REPLACE IMAGES
    public function update(Request $request, $id)
    {

        $product = Product::findOrFail($id);

        $data = $request->only([
            'category_id',
            'product_name',
            'price',
            'discount',
            'avail_count'
        ]);

        $images = $request->file('images', []);
        $uploadErrors = [];

        if (is_array($images)) {
            foreach ($images as $index => $img) {
                if ($img instanceof UploadedFile && ! $img->isValid()) {
                    $uploadErrors["images.$index"] = $this->uploadErrorMessage($img->getError());
                }
            }
        } elseif ($images instanceof UploadedFile && ! $images->isValid()) {
            $uploadErrors['images.0'] = $this->uploadErrorMessage($images->getError());
        }

        if (! empty($uploadErrors)) {
            return redirect()->back()->withInput()->withErrors($uploadErrors);
        }

        $data['user_id'] = auth()->id();

        // ✅ UPDATE PRODUCT DATA ONLY
        $product->update($data);

        // ✅ ADD NEW IMAGES (DO NOT DELETE OLD ONES)
        $images = $request->file('images', []);
        if (is_array($images)) {
            foreach ($images as $img) {
                if (! $img instanceof UploadedFile || ! $img->isValid()) {
                    continue;
                }

                $path = $this->storeCompressedImage($img, 'products', 30);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        } elseif ($images instanceof UploadedFile && $images->isValid()) {
            $path = $this->storeCompressedImage($images, 'products', 30);

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    // ✅ DELETE SINGLE IMAGE (button use)
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image deleted');
    }

    // ✅ UPDATE STATUS
    public function updateStatus(Request $request, $id)
    {
        $product = Product::where('user_id', auth()->id())
                  ->findOrFail($id);

        $request->validate([
            'status' => 'required|in:approved,reject,hold'
        ]);

        $product->status = $request->status;
        $product->save();

        return back()->with('success', 'Status updated successfully');
    }

    protected function uploadErrorMessage(int $errorCode): string
    {
        return match ($errorCode) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => sprintf(
                'The uploaded image is too large. Maximum upload size is %s. Please use a smaller file or increase PHP upload limits.',
                $this->getPhpUploadLimit()
            ),
            UPLOAD_ERR_PARTIAL => 'The image upload was interrupted. Please try again.',
            UPLOAD_ERR_NO_FILE => 'No image file was selected.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder on the server.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write the uploaded image to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension blocked the image upload.',
            default => 'The image upload failed. Please try again.',
        };
    }

    protected function getPhpUploadLimit(): string
    {
        $uploadMaxFilesize = $this->convertPhpSizeToBytes(ini_get('upload_max_filesize'));
        $postMaxSize = $this->convertPhpSizeToBytes(ini_get('post_max_size'));
        $bytes = min($uploadMaxFilesize, $postMaxSize);

        return $this->formatBytes($bytes);
    }

    protected function convertPhpSizeToBytes(string $size): int
    {
        $unit = strtolower(substr($size, -1));
        $value = (int) $size;

        return match ($unit) {
            'g' => $value * 1024 * 1024 * 1024,
            'm' => $value * 1024 * 1024,
            'k' => $value * 1024,
            default => $value,
        };
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        }

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }
    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);

        // 🔥 delete images first
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
