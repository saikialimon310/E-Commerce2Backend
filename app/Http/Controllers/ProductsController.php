<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'image' => 'required|image',
            'price' => 'required',
            'discount' => 'required',
            'avail_count' => 'required'
        ]);

        // Image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
            $data['image'] = $image;
            $data['booked_count'] = 0;
        }

        Product::create($data);

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product','categories'));
    }

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

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
            $data['image'] = $image;
        }

        $product->update($data);

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index');
    }
}