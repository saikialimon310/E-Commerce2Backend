<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyCart;

class MyCartApiController extends Controller
{
    // ✅ GET ALL CART ITEMS (for the authenticated user only)
    public function index(Request $request)
    {
        $carts = MyCart::with(['user', 'product'])
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Cart list fetched successfully',
            'data' => $carts
        ], 200);
    }

    // ✅ STORE NEW CART ITEM
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = MyCart::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart',
            'data' => $cart
        ], 201);
    }

    // ✅ SHOW SINGLE CART ITEM
    public function show($id)
    {
        $cart = MyCart::with(['user', 'product'])->find($id);

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $cart
        ], 200);
    }

    // ✅ UPDATE CART ITEM
    public function update(Request $request, $id)
    {
        $cart = MyCart::find($id);

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully',
            'data' => $cart
        ], 200);
    }

    // ✅ DELETE CART ITEM
    public function destroy($id)
    {
        $cart = MyCart::find($id);

        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'status' => true,
            'message' => 'Cart item deleted successfully'
        ], 200);
    }
}
