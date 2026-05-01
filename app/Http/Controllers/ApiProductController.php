<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ApiProductController extends Controller
{
    public function getCategory()
    {
        $categories = Category::all();

        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }

    public function getProduct()
    {
        $products = Product::with('category')->get();

        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }
}