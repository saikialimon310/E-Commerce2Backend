<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MyOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderApiController extends Controller
{
    public function myOrders()
    {
        $orders = MyOrder::with(['seller', 'product.images'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'My orders fetched successfully',
            'data' => $orders,
        ], 200);
    }

    public function recentOrders()
    {
        $orders = MyOrder::with(['user', 'product'])
            ->where('status', 'pending')
            ->whereNull('order_confirmed_at')
            ->whereNull('delivery_date')
            ->whereHas('product', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Recent orders fetched successfully',
            'data' => $orders,
        ], 200);
    }

    public function myOrderSaler()
    {
        $orders = MyOrder::with(['user', 'product'])
            ->where('seller_id', Auth::id())
            ->whereIn('status', ['confirmed', 'delivered'])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Seller accepted orders fetched successfully',
            'data' => $orders,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string',
            'delivery_phone_no' => 'required|string|max:20',
            'payment_mode' => 'nullable|string|max:255',
            'expected_delivery_date' => 'nullable|date',
        ]);

        $product = Product::find($request->product_id);
        $quantity = (int) $request->quantity;
        $price = (float) $product->price;

        $order = MyOrder::create([
            'user_id' => Auth::id(),
            // 'seller_id' => $product->user_id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'delivery_address' => $request->delivery_address,
            'delivery_phone_no' => $request->delivery_phone_no,
            'price' => $price,
            'total_price' => $price * $quantity,
            'status' => 'pending',
            'payment_mode' => $request->payment_mode,
            'order_date' => now(),
            'expected_delivery_date' => $request->expected_delivery_date,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order placed successfully',
            'data' => $order->load(['user', 'seller', 'product']),
        ], 201);
    }

    public function confirm($id)
    {
        $order = MyOrder::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found',
            ], 404);
        }

        if ($order->status === 'confirmed') {
            return response()->json([
                'status' => false,
                'message' => 'Order already confirmed',
            ], 409);
        }

        $order->update([
            'seller_id' => Auth::id(),
            'status' => 'confirmed',
            'order_confirmed_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order confirmed successfully',
            'data' => $order->load(['user', 'seller', 'product']),
        ], 200);
    }

    public function delivered($id)
    {
        $order = MyOrder::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found',
            ], 404);
        }

        if ($order->status === 'delivered') {
            return response()->json([
                'status' => false,
                'message' => 'Order already marked as delivered',
            ], 409);
        }

        $order->update([
            'seller_id' => Auth::id(),
            'status' => 'delivered',
            'order_delivered_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order marked as delivered successfully',
            'data' => $order->load(['user', 'seller', 'product']),
        ], 200);
    }
}
