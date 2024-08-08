@extends('layouts.app')

@section('title', "> ".$product->name)

@section('content')

<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" /></div>
            <div class="col-md-6">
                <div class="small mb-1">&nbsp;</div>
                <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                <div class="fs-5 mb-5">
                    <span>${{number_format($product->price, 2)}}</span>
                </div>
                <p class="lead"></p>
                <div class="d-flex">
                    <a class='btn btn-outline-dark mt-auto mx-1' href="{{ route('home', ['page' => $page]) }}">Back to Products</a>
                    <a class="btn btn-outline-dark mt-auto" href="{{ route('checkout', $product) }}"> <i class="bi-cart-fill me-1"></i> Buy</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection