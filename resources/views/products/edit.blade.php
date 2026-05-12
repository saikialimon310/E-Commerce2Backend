@extends('layouts.app-admin')

@section('content')

<div class="container">
<div class="page-inner">
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

<form action="{{ route('products.update',$product->id) }}"
      method="POST"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="row">

<!-- CATEGORY -->
<div class="col-md-6 mb-3">
    <label>Category</label>

    <select name="category_id" class="form-control">

        @foreach($categories as $cat)

            <option value="{{ $cat->id }}"
                {{ $product->category_id == $cat->id ? 'selected' : '' }}>

                {{ $cat->name }}

            </option>

        @endforeach

    </select>
</div>

<!-- PRODUCT NAME -->
<div class="col-md-6 mb-3">
    <label>Product Name</label>

    <input type="text"
           name="product_name"
           value="{{ $product->product_name }}"
           class="form-control">
</div>

<!-- PRICE -->
<div class="col-md-6 mb-3">
    <label>Price</label>

    <input type="text"
           name="price"
           value="{{ $product->price }}"
           class="form-control">
</div>

<!-- DISCOUNT -->
<div class="col-md-6 mb-3">
    <label>Discount</label>

    <input type="text"
           name="discount"
           value="{{ $product->discount }}"
           class="form-control">
</div>

<!-- AVAILABLE COUNT -->
<div class="col-md-6 mb-3">
    <label>Available Count</label>

    <input type="text"
           name="avail_count"
           value="{{ $product->avail_count }}"
           class="form-control">
</div>

<!-- EXISTING IMAGES -->
<div class="col-md-12 mt-3">

    <label>
        <b>Existing Images</b>
    </label>

    <br>

    @foreach($product->images as $img)

        <div style="display:inline-block; margin:10px; text-align:center;">

            <img src="{{ asset('storage/'.$img->image) }}"
                 width="100"
                 height="100"
                 style="object-fit:cover; border-radius:5px; border:1px solid #ddd;">

            <br>

            <button type="button"
                    onclick="deleteImage({{ $img->id }})"
                    class="btn btn-danger btn-sm mt-2">

                Delete

            </button>

        </div>

    @endforeach

</div>

<!-- ADD NEW IMAGES -->
<div class="col-md-12 mt-4">

    <label>
        <b>Product Images</b>
    </label>

    <!-- BUTTON -->
    <button type="button"
            class="btn btn-primary btn-sm mb-2"
            onclick="addImage()">

        + Add Image

    </button>

    <!-- IMAGE INPUT BOX -->
    <div id="image-box"></div>

</div>

</div>

<!-- UPDATE BUTTON -->
<button type="submit" class="btn btn-success mt-3">
    Update Product
</button>

</form>

<!-- DELETE IMAGE FORM -->
<form id="delete-form" method="POST">
    @csrf
    @method('DELETE')
</form>

</div>
</div>
</div>
</div>

<script>

let i = 0;

/* ADD MULTIPLE IMAGE INPUTS */
function addImage()
{
    let html = `
        <div id="img-${i}" class="mb-3">

            <input type="file"
                   name="images[]"
                   class="form-control"
                   onchange="preview(event, ${i})">

            <img id="preview-${i}"
                 width="100"
                 height="100"
                 style="display:none;
                        margin-top:10px;
                        object-fit:cover;
                        border-radius:5px;
                        border:1px solid #ddd;">

            <br>

            <button type="button"
                    onclick="removeImg(${i})"
                    class="btn btn-danger btn-sm mt-2">

                Delete

            </button>

        </div>
    `;

    document.getElementById('image-box')
            .insertAdjacentHTML('beforeend', html);

    i++;
}

/* PREVIEW IMAGE */
function preview(event, id)
{
    let reader = new FileReader();

    reader.onload = function(e)
    {
        let img = document.getElementById('preview-' + id);

        img.src = e.target.result;

        img.style.display = 'block';
    }

    reader.readAsDataURL(event.target.files[0]);
}

/* REMOVE NEW IMAGE INPUT */
function removeImg(id)
{
    document.getElementById('img-' + id).remove();
}

/* DELETE OLD IMAGE */
function deleteImage(id)
{
    if(confirm('Delete image?'))
    {
        let form = document.getElementById('delete-form');

        form.action = '/product-image/' + id;

        form.submit();
    }
}

</script>

@endsection