@extends('layouts.app-admin')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="card-title mb-0">
                Edit Available Product
            </h4>

        </div>

        <div class="card-body">

            <form action="{{ route('available-products.update', $availableProduct->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <!-- PRODUCT -->
                <div class="mb-3">

                    <label class="form-label">
                        Product
                    </label>

                    <select name="product_id"
                            class="form-control"
                            required>

                        @foreach($products as $product)

                            <option value="{{ $product->id }}"
                                {{ $availableProduct->product_id == $product->id ? 'selected' : '' }}>

                                {{ $product->product_name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <!-- AVAILABLE QUANTITY -->
                <div class="mb-3">

                    <label class="form-label">
                        Available Quantity
                    </label>

                    <input type="number"
                           name="available_quantity"
                           value="{{ $availableProduct->available_quantity }}"
                           class="form-control"
                           required>

                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="btn btn-primary">

                    Update

                </button>

            </form>

        </div>

    </div>

</div>

@endsection