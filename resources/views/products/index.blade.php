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
                                        <th>Images</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Available</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($products as $key => $product)
                                    <tr>

                                        <!-- SL -->
                                        <td>{{ $key + 1 }}</td>

                                        <!-- Category -->
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>

                                        <!-- Name -->
                                        <td>{{ $product->product_name }}</td>

                                        <!-- ✅ MULTIPLE IMAGES -->
                                        <td>
                                            @if($product->images->count() > 0)

                                                @foreach($product->images->take(3) as $img)
                                                    <img src="{{ asset('storage/'.$img->image) }}" 
                                                         width="40" 
                                                         style="margin-right:5px; border-radius:5px;">
                                                @endforeach

                                                @if($product->images->count() > 3)
                                                    <span class="badge bg-secondary">
                                                        +{{ $product->images->count() - 3 }}
                                                    </span>
                                                @endif

                                            @else
                                                <span>No Image</span>
                                            @endif
                                        </td>

                                        <!-- Price -->
                                        <td>{{ $product->price }}</td>

                                        <!-- Discount -->
                                        <td>{{ $product->discount }}</td>

                                        <!-- Available -->
                                        <td>{{ $product->avail_count }}</td>

                                        <!-- STATUS -->
                                        <td>
                                            <form action="{{ route('products.status.update', $product->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <select name="status" class="form-select form-select-sm"
                                                        onchange="this.form.submit()">

                                                    <option value="approved"
                                                        {{ $product->status == 'approved' ? 'selected' : '' }}>
                                                        Approved
                                                    </option>

                                                    <option value="reject"
                                                        {{ $product->status == 'reject' ? 'selected' : '' }}>
                                                        Reject
                                                    </option>

                                                    <option value="hold"
                                                        {{ $product->status == 'hold' ? 'selected' : '' }}>
                                                        Hold
                                                    </option>

                                                </select>
                                            </form>
                                        </td>

                                        <!-- ACTION -->
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
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Delete this product?')">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
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