@extends('layouts.app-admin')

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Add Category</div>

                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <!-- Category Name -->
                                <div class="col-md-6 mb-3">
                                    <label>Category Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <!-- Submit -->
                            <div class="mt-3">
                                <button class="btn btn-success">Save Category</button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection