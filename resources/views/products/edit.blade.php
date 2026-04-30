@extends('layouts.app-admin')

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Edit Product</div>

                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <!-- Category -->
                                <div class="col-md-6 mb-3">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Product Name -->
                                <div class="col-md-6 mb-3">
                                    <label>Product Name</label>
                                    <input type="text" name="product_name"
                                           value="{{ $product->product_name }}"
                                           class="form-control" required>
                                </div>

                                <!-- Image -->
                                <div class="col-md-6 mb-3">
                                    <label>Product Image</label>
                                    <input type="file" name="image" class="form-control">

                                    <br>
                                    <img src="{{ asset('storage/'.$product->image) }}" width="80">
                                </div>

                                <!-- Price -->
                                <div class="col-md-6 mb-3">
                                    <label>Price</label>
                                    <input type="text" name="price"
                                           value="{{ $product->price }}"
                                           class="form-control" required>
                                </div>

                                <!-- Discount -->
                                <div class="col-md-6 mb-3">
                                    <label>Discount</label>
                                    <input type="text" name="discount"
                                           value="{{ $product->discount }}"
                                           class="form-control" required>
                                </div>

                                <!-- Available Count -->
                                <div class="col-md-6 mb-3">
                                    <label>Available Count</label>
                                    <input type="text" name="avail_count"
                                           value="{{ $product->avail_count }}"
                                           class="form-control" required>
                                </div>

                            </div>

                            <!-- Submit -->
                            <div class="mt-3">
                                <button class="btn btn-success">Update Product</button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection