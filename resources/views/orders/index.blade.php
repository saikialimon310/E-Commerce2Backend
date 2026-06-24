@extends('layouts.app-admin')

@section('content')

<div class="container">
    <div class="page-inner">

        <div class="row">
            <div class="col-md-12">

                <div class="card card-round">

                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">

                            <div class="card-title">
                                Orders
                            </div>

                        </div>
                    </div>

                    <div class="card-body p-0">

                        {{-- Success flash message --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">

                            <table class="table align-items-center mb-0">

                                <thead class="thead-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Product</th>
                                        <th>Image</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Order Date</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($orders as $key => $order)

                                    <tr>

                                        <!-- SL -->
                                        <td>{{ $key + 1 }}</td>

                                        <!-- Product -->
                                        <td>
                                            {{ $order->product->product_name ?? 'N/A' }}
                                        </td>

                                        <!-- Product Image -->
                                        <td>

                                            @if($order->product && $order->product->images->count() > 0)

                                                <img src="{{ asset('storage/'.$order->product->images->first()->image) }}"
                                                     width="50"
                                                     style="border-radius:5px;">

                                            @else

                                                <span>No Image</span>

                                            @endif

                                        </td>

                                        <!-- Customer -->
                                        <td>
                                            {{ $order->user->name ?? 'N/A' }}
                                        </td>

                                        <!-- Phone -->
                                        <td>
                                            {{ $order->delivery_phone_no }}
                                        </td>

                                        <!-- Quantity -->
                                        <td>
                                            {{ $order->quantity }}
                                        </td>

                                        <!-- Total -->
                                        <td>
                                            ₹{{ $order->total_price }}
                                        </td>

                                        <!-- Status -->
                                        <td>

                                            @if($order->status == 'pending')

                                                <span class="badge bg-warning">
                                                    Pending
                                                </span>

                                            @elseif($order->status == 'confirmed')

                                                <span class="badge bg-primary">
                                                    Confirmed
                                                </span>

                                            @elseif($order->status == 'delivered')

                                                <span class="badge bg-success">
                                                    Delivered
                                                </span>

                                            @else

                                                <span class="badge bg-secondary">
                                                    {{ $order->status }}
                                                </span>

                                            @endif

                                        </td>

                                        <!-- Order Date -->
                                        <td>
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                                        </td>

                                        <!-- Action -->
                                        <td class="text-end" style="white-space: nowrap;">

                                            @if($order->status == 'pending')

                                                {{-- Confirm button --}}
                                                <form action="{{ route('orders.status', $order->id) }}"
                                                      method="POST"
                                                      style="display:inline-block;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit"
                                                            class="btn btn-primary btn-sm"
                                                            onclick="return confirm('Confirm this order?')">
                                                        Confirm
                                                    </button>
                                                </form>

                                            @elseif($order->status == 'confirmed')

                                                {{-- Mark as Delivered button --}}
                                                <form action="{{ route('orders.status', $order->id) }}"
                                                      method="POST"
                                                      style="display:inline-block;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="delivered">
                                                    <button type="submit"
                                                            class="btn btn-success btn-sm"
                                                            onclick="return confirm('Mark this order as Delivered?')">
                                                        Mark as Delivered
                                                    </button>
                                                </form>

                                            @else

                                                {{-- Already delivered or other terminal status --}}
                                                <span class="text-muted small">No action</span>

                                            @endif

                                        </td>

                                    </tr>

                                    @empty

                                    <tr>
                                        <td colspan="10" class="text-center">
                                            No orders found
                                        </td>
                                    </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection

