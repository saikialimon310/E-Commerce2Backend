@extends('layouts.app-admin')

@section('content')

<div class="page-inner">

    <div class="page-header">
        <h4 class="page-title">Available Products</h4>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Available Products List</div>

                    <a href="{{ route('available-products.create') }}" class="btn btn-primary btn-sm">
                        Add Available Product
                    </a>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Product_Name</th>
                                    <th>User</th>
                                    <th>Available</th>
                                    <th>Booked</th>
                                    <th>Sold</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($availableProducts as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                                        <td>{{ $item->user->name ?? 'N/A' }}</td>

                                        <td>{{ $item->available_quantity }}</td>
                                        <td>{{ $item->booked_quantity }}</td>
                                        <td>{{ $item->total_sell_quantity }}</td>

                                        <td>
                                            <a href="{{ route('available-products.edit', $item->id) }}" 
                                               class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('available-products.delete', $item->id) }}" 
                                                  method="POST" 
                                                  style="display:inline-block;">
                                                @csrf

                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No Available Products Found
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

@endsection