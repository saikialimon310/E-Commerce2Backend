@extends('layouts.app-admin')

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Products</div>

                            <!-- SAME STYLE BUTTON -->
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                Add Product
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">

                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Category</th>
                                        <th>Product Name</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Available</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($products as $key => $product)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            {{ $product->category->name ?? 'N/A' }}
                                        </td>

                                        <td>{{ $product->product_name }}</td>

                                        <td>
                                            <img src="{{ asset('storage/'.$product->image) }}" width="60">
                                        </td>

                                        <td>{{ $product->price }}</td>

                                        <td>{{ $product->discount }}</td>

                                        <td>{{ $product->avail_count }}</td>

                                        <td class="text-end">

                                            <!-- EDIT -->
                                            <a href="{{ route('products.edit',$product->id) }}"
                                               class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <!-- DELETE -->
                                            <form action="{{ route('products.delete',$product->id) }}"
                                                  method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                <button class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            No products found
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