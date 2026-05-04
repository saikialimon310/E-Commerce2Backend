@extends('layouts.app-admin')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Edit Available Product</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('available-products.update', $availableProduct->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Product</label>
                    <select name="product_id" class="form-control">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                {{ $availableProduct->product_id == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-control">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $availableProduct->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number"
                           name="available_quantity"
                           value="{{ $availableProduct->available_quantity }}"
                           class="form-control">
                </div>

                <button class="btn btn-primary">Update</button>
            </form>
        </div>

    </div>

</div>

@endsection