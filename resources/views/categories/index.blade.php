@extends('layouts.app-admin')

@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Categories</div>

                            <!-- FIXED BUTTON -->
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                Add categories
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>SL</th>
                                        <th class="text-end">Category Name</th>
                                        <th class="text-end">Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="text-end">{{ $category->name }}</td>
                                        <td class="text-end">
                                            {{ $category->status ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td class="text-end">

                                            <!-- EDIT -->
                                            <a href="{{ route('categories.edit', $category->id) }}" 
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <!-- DELETE -->
                                            <form action="{{ route('categories.delete', $category->id) }}" 
                                                    method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>

                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                No categories found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection





