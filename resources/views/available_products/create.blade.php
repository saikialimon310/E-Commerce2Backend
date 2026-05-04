@extends('layouts.app-admin')

@section('content')

<div class="page-inner">

    <div class="page-header">
        <h4 class="page-title">Add Available Product</h4>
    </div>

    <div class="row">
        <div class="col-md-8">

            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Add Details</div>
                </div>

                <div class="card-body">

                    <form action="{{ route('available-products.store') }}" method="POST">
                        @csrf

                        <!-- Product Dropdown -->
                        <div class="form-group mb-3">
                            <label>Product</label>
                            <select name="product_id" class="form-control" required>
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- User Dropdown -->
                        <div class="form-group mb-3">
                            <label>User</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">-- Select User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Available Quantity -->
                        <div class="form-group mb-3">
                            <label>Available Quantity</label>
                            <input type="number" name="available_quantity" class="form-control" required>
                        </div>

                        <!-- Booked Quantity -->
                        <div class="form-group mb-3">
                            <label>Booked Quantity</label>
                            <input type="number" name="booked_quantity" class="form-control" value="0">
                        </div>

                        <!-- Sold Quantity -->
                        <div class="form-group mb-3">
                            <label>Sold Quantity</label>
                            <input type="number" name="total_sell_quantity" class="form-control" value="0">
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">
                                Save
                            </button>

                            <a href="{{ route('available-products.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection