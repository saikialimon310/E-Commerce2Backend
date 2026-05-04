<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\AvailableProduct;
use Illuminate\Http\Request;

class AvailableProductController extends Controller
{
    // ✅ Show List
    public function index()
    {
        $availableProducts = AvailableProduct::with(['product', 'user'])->get();

        return view('available_products.index', compact('availableProducts'));
    }

    // ✅ Show Create Form
    public function create()
    {
        $products = Product::all();
        $users = User::all();

        return view('available_products.create', compact('products', 'users'));
    }

    // ✅ Store Data
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'            => 'required|exists:products,id',
            'user_id'               => 'required|exists:users,id',
            'available_quantity'    => 'required|integer|min:0',
            'booked_quantity'       => 'nullable|integer|min:0',
            'total_sell_quantity'   => 'nullable|integer|min:0',
        ]);

        AvailableProduct::create($data);

        return redirect()->route('available-products.index')
                         ->with('success', 'Added successfully');
    }

    // ✅ Edit Form
    public function edit($id)
    {
        $availableProduct = AvailableProduct::findOrFail($id);
        $products = Product::all();
        $users = User::all();

        return view('available_products.edit', compact('availableProduct', 'products', 'users'));
    }

    // ✅ Update Data
    public function update(Request $request, $id)
    {
        $availableProduct = AvailableProduct::findOrFail($id);

        $data = $request->validate([
            'product_id'            => 'required|exists:products,id',
            'user_id'               => 'required|exists:users,id',
            'available_quantity'    => 'required|integer|min:0',
            'booked_quantity'       => 'nullable|integer|min:0',
            'total_sell_quantity'   => 'nullable|integer|min:0',
        ]);

        $availableProduct->update($data);

        return redirect()->route('available-products.index')
                         ->with('success', 'Updated successfully');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $availableProduct = AvailableProduct::findOrFail($id);
        $availableProduct->delete();

        return redirect()->route('available-products.index')
                         ->with('success', 'Deleted successfully');
    }
}