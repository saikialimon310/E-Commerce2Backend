<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    // ✅ SHOW ALL PRODUCTS
    public function index()
    {
        $products = Product::with(['images', 'category'])->get();
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
        $data = $request->validate([
            'category_id'   => 'required',
            'product_name'  => 'required',
            'price'         => 'required',
            'discount'      => 'required',
            'avail_count'   => 'required'
        ]);

        // not used but required column fix
        $data['image'] = 'NA';
        $data['booked_count'] = 0;
        $data['status'] = 'hold';

        $product = Product::create($data);

        // ✅ MULTIPLE IMAGE UPLOAD
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $path
                ]);
            }
        }

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

        $data = $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'avail_count' => 'required'
        ]);

        // ✅ UPDATE PRODUCT DATA ONLY
        $product->update($data);

        // ✅ ADD NEW IMAGES (DO NOT DELETE OLD ONES)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {

                $path = $img->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
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
        $product = Product::findOrFail($id);

        $request->validate([
            'status' => 'required|in:approved,reject,hold'
        ]);

        $product->status = $request->status;
        $product->save();

        return back()->with('success', 'Status updated successfully');
    }

    // ✅ DELETE PRODUCT (WITH IMAGES)
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