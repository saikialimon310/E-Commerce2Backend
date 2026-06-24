<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsApiController extends Controller
{
    // GET ALL PRODUCTS
    public function index()
    {
        $products = Product::with(['images', 'category'])->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ], 200);
    }

    // STORE PRODUCT
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'   => 'required',
            'product_name'  => 'required',
            'price'         => 'required',
            'discount'      => 'required',
            'avail_count'   => 'required',
            'images'        => 'nullable|array',
            'images.*'      => 'image|mimes:jpg,jpeg,png'
        ]);

        $data['image'] = 'NA';
        $data['booked_count'] = 0;
        $data['status'] = 'hold';

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $this->storeCompressedImage($img, 'products', 100);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product->load('images')
        ], 201);
    }

    // SHOW SINGLE PRODUCT
    public function show($id)
    {
        $product = Product::with(['images', 'category'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => $product
        ], 200);
    }

    // UPDATE PRODUCT
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'avail_count' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:100'
        ]);

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'product' => $product->load('images')
        ], 200);
    }

    // DELETE IMAGE
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ], 200);
    }

    // UPDATE STATUS
    public function updateStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'status' => 'required|in:approved,reject,hold'
        ]);

        $product->status = $request->status;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ], 200);
    }

    // DELETE PRODUCT
    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
