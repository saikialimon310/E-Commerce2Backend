@extends('layouts.app-admin')

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Add Product</div>

                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <!-- Category -->
                                <div class="col-md-6 mb-3">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Product Name -->
                                <div class="col-md-6 mb-3">
                                    <label>Product Name</label>
                                    <input type="text" name="product_name" class="form-control" required>
                                </div>

                                <!-- Image -->
                                <div class="col-md-6 mb-3">
                                    <label>Product Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>

                                <!-- Price -->
                                <div class="col-md-6 mb-3">
                                    <label>Price</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>

                                <!-- Discount -->
                                <div class="col-md-6 mb-3">
                                    <label>Discount</label>
                                    <input type="number" name="discount" class="form-control" required>
                                </div>

                                <!-- Available Count -->
                                <div class="col-md-6 mb-3">
                                    <label>Available Count</label>
                                    <input type="number" name="avail_count" class="form-control" required>
                                </div>

                            </div>

                            <!-- Submit -->
                            <div class="mt-3">
                                <button class="btn btn-success">Save Product</button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection