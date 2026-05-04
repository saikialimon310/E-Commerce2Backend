@extends('layouts.app-admin')

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Cart List</div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">

                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>User</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($carts as $key => $cart)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            {{ $cart->user->name ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $cart->product->product_name ?? 'N/A' }}
                                        </td>

                                        <td>{{ $cart->quantity }}</td>

                                        <td>{{ $cart->created_at }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            No cart data found
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