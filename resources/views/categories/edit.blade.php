@extends('layouts.app-admin')

@section('content')

<div class="container">
    <h3>Edit Category</h3>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Category Name</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $category->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$category->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>

</div>

@endsection