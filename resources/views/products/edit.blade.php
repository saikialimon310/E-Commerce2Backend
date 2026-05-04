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

                        <!-- ✅ MAIN UPDATE FORM -->
                        <form action="{{ route('products.update', $product->id) }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- ✅ FIXED -->

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

                                <!-- EXISTING IMAGES -->
                                <div class="col-md-12 mb-3">
                                    <label>Existing Images</label><br>

                                    @foreach($product->images as $img)
                                        <div style="display:inline-block; margin:10px; text-align:center;">

                                            <img src="{{ asset('storage/'.$img->image) }}" width="80">

                                            <!-- ✅ DELETE BUTTON (NO FORM INSIDE MAIN FORM) -->
                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="deleteImage({{ $img->id }})">
                                                Delete
                                            </button>

                                        </div>
                                    @endforeach
                                </div>

                                <!-- Add New Images -->
                                <div class="col-md-12 mb-3">
                                    <label>Add New Images</label>
                                    <input type="file" name="images[]" class="form-control" multiple>
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

                        <!-- ✅ SEPARATE DELETE FORM -->
                        <form id="delete-image-form" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- ✅ JS FOR DELETE -->
<script>
function deleteImage(id) {
    if(confirm('Delete this image?')) {
        let form = document.getElementById('delete-image-form');
        form.action = "{{ url('product-image') }}/" + id;
        form.submit();
    }
}
</script>

@endsection