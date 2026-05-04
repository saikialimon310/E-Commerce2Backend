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

                                <!-- ✅ IMAGE SECTION -->
                                <div class="col-md-12 mt-4">
                                    <label><b>Product Images</b></label>

                                    <button type="button" class="btn btn-primary btn-sm mb-3" onclick="addImage()">
                                        + Add Image
                                    </button>

                                    <div id="image-box"></div>
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

<!-- ✅ SCRIPT -->
<script>
let i = 0;

// ADD IMAGE INPUT
function addImage() {
    let html = `
        <div id="img-${i}" 
             style="margin-bottom:20px; border:1px solid #ddd; padding:10px; border-radius:8px;">
            
            <input type="file" name="images[]" 
                   onchange="preview(event, ${i})"
                   class="form-control mb-2" required>

            <img id="preview-${i}" 
                 style="display:none; max-width:120px; border-radius:6px; margin-bottom:10px;">

            <br>

            <button type="button" 
                    class="btn btn-danger btn-sm"
                    onclick="removeImg(${i})">
                Delete
            </button>

        </div>
    `;

    let container = document.getElementById('image-box');
    container.insertAdjacentHTML('beforeend', html);

    // ✅ FIXED SCROLL (MAIN SOLUTION)
    let panel = document.querySelector('.main-panel');
    panel.scrollTop = panel.scrollHeight;

    i++;
}

// IMAGE PREVIEW
function preview(event, id) {
    let reader = new FileReader();

    reader.onload = function() {
        let img = document.getElementById('preview-' + id);
        img.src = reader.result;
        img.style.display = 'block';

        // ✅ SCROLL AGAIN AFTER IMAGE LOAD
        let panel = document.querySelector('.main-panel');
        panel.scrollTop = panel.scrollHeight;
    }

    reader.readAsDataURL(event.target.files[0]);
}

// REMOVE IMAGE
function removeImg(id) {
    document.getElementById('img-' + id).remove();
}
</script>

@endsection