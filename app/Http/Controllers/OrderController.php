<?php

namespace App\Http\Controllers;

use App\Models\MyOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // All orders
    public function index()
    {
        $orders = MyOrder::with(['user', 'seller', 'product.images'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // Single order details using ID
    public function show($id)
    {
        $order = MyOrder::with(['user', 'seller', 'product.images'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    // Update order status (confirm / delivered)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,delivered',
        ]);

        $order = MyOrder::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')
            ->with('success', 'Order status updated to ' . ucfirst($request->status) . '.');
    }
}
