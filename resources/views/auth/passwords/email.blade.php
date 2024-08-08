@extends('layouts.app')

@section('content')
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-3 my-3">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">{{ __('Reset Password') }}</h1>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5 mb-5">
        <div class="row align-items-center">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="col-md-6 offset-md-4">
                           <p>Please enter your email address.</p>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
