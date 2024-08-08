@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-3 my-3">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Manage Products</h1>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">New Product</a>
    @include('layouts.alerts')
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td><img src="{{ Storage::url($product->image) }}" width="100" alt="{{ $product->name }}"></td>
                    <td>{{ $product->name }}</td>
                    <td>${{number_format($product->price, 2)}}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        No products to display.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
</section>
@endsection