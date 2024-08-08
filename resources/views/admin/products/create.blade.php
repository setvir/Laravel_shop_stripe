@extends('layouts.app')
@section('title', 'Create Product')
@section('content')
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-3 my-3">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Create Product</h1>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @include('layouts.alerts')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price"  step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</section>
@endsection