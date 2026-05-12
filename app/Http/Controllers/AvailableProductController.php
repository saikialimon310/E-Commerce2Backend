<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\AvailableProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailableProductController extends Controller
{
    // ✅ SHOW LIST
    public function index()
    {
        $availableProducts = AvailableProduct::with(['product', 'user'])->get();

        return view('available_products.index', compact('availableProducts'));
    }

    // ✅ SHOW CREATE FORM
    public function create()
    {
        $products = Product::all();

        return view('available_products.create', compact('products'));
    }

    // ✅ STORE DATA
    public function store(Request $request)
    {
        $request->validate([
            'product_id'         => 'required|exists:products,id',
            'available_quantity' => 'required|integer|min:0',
        ]);

        // CHECK PRODUCT ALREADY EXISTS
        $availableProduct = AvailableProduct::where('product_id', $request->product_id)
                                            ->first();

        if ($availableProduct)
        {
            // INCREMENT EXISTING QUANTITY
            $availableProduct->update([
                'available_quantity' =>
                    $availableProduct->available_quantity + $request->available_quantity,
            ]);
        }
        else
        {
            // CREATE NEW
            AvailableProduct::create([
                'product_id'          => $request->product_id,
                'user_id'             => Auth::id(),
                'available_quantity'  => $request->available_quantity,
                'booked_quantity'     => 0,
                'total_sell_quantity' => 0,
            ]);
        }

        return redirect()->route('available-products.index')
                         ->with('success', 'Added successfully');
    }

    // ✅ EDIT FORM
    public function edit($id)
    {
        $availableProduct = AvailableProduct::findOrFail($id);

        $products = Product::all();

        return view('available_products.edit', compact('availableProduct', 'products'));
    }

    // ✅ UPDATE DATA
    public function update(Request $request, $id)
    {
        $availableProduct = AvailableProduct::findOrFail($id);

        $request->validate([
            'product_id'         => 'required|exists:products,id',
            'available_quantity' => 'required|integer|min:0',
        ]);

        $availableProduct->update([

            'product_id' => $request->product_id,

            // ADD INPUT VALUE + EXISTING VALUE
            'available_quantity' =>
                $availableProduct->available_quantity + $request->available_quantity,

        ]);

        return redirect()->route('available-products.index')
                         ->with('success', 'Updated successfully');
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $availableProduct = AvailableProduct::findOrFail($id);

        $availableProduct->delete();

        return redirect()->route('available-products.index')
                         ->with('success', 'Deleted successfully');
    }
}