@extends('layouts.app')

@section('title', "Home Page")

@section('content')
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-3 my-3">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
        </div>
    </div>
</header>
@include('layouts.alerts')
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-left" >
        @forelse($products as $product)
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img class="card-img-top" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{ $product->name }}</h5>
                            <!-- Product price-->
                            ${{number_format($product->price, 2)}}
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('products.show', $product) }}">View</a></div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h5 class="fw-bolder">No products to display</h5>
                            <!-- Product price-->
                            Please check back later ...
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
        </div>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
    </div>
</section>
@endsection