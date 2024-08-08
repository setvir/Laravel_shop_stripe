@extends('layouts.app')

@section('title', "Thank you")

@section('content')
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-3 my-3">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Thank You!</h1>
        </div>
    </div>
</header>
<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6">
                <img src="{{ Storage::url($transaction->product->image) }}" alt="{{ $transaction->product->name }}" style="width:90%;">
            </div>
            <div class="col-md-6">
                <h2 class="card-title">{{ $transaction->product->name }}</h2>
                <p class="card-text"><strong>Price: </strong>${{number_format($transaction->amount,2)}}</p>
                <p>You will receive a confirmation email as soon as the payment has been processed.</p>
            </div>
        </div>
    </div>
</section>
@endsection