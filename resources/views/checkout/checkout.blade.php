@extends('layouts.app')

@section('title', "Checkout ".$product->name)

@section('content')

<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-3 my-3">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Checkout</h1>
        </div>
    </div>
</header>
<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6 offset-md-3">
                <div class="small mb-1">&nbsp;</div>
                <div class="fs-5 mb-5">
                    @include('layouts.alerts')
                    <p>You are about to purchase "{{$product->name}}" for</p>
                    <span>${{number_format($product->price, 2)}}</span>
                </div>
                <form action="{{ route('pay', $product) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Please enter your email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-outline-dark mt-auto">Proceed to Payment</button>
            </div>
        </div>
    </div>
</section>
@endsection