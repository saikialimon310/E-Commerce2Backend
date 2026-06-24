<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductStoreApiController extends Controller
{
    public function store(Request $request)
    {
        // ✅ VALIDATION (MATCH FLUTTER)
        $request->validate([

            'category_id'   => 'required|integer',
            'product_name'  => 'required|string',
            'price'         => 'required|numeric',
            'discount'      => 'required|numeric',
            'avail_count'   => 'required|integer',
            'images'        => 'required|array',
            'images.*'      => 'image|mimes:jpg,jpeg,png',
        ]);

        // ✅ CREATE PRODUCT
        $product = Product::create([
            'user_id'       => Auth::user()->id,
            'category_id'   => $request->category_id,
            'product_name'  => $request->product_name,
            'price'         => $request->price,
            'discount'      => $request->discount,
            'avail_count'   => $request->avail_count,
            'image'         => 'NA',
            'booked_count'  => 0,
            'status'        => 'hold',
        ]);

        // ✅ STORE MULTIPLE IMAGES
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

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'product' => $product->load('images')
        ], 201);
    }
    public function userProducts()
    {
        // dd(Auth::user()->id);
        $products = Product::with('images')
            ->where('user_id', Auth::user()->id)
            ->get();

        return response()->json($products);
    }

}
