@extends('layouts.app')

@section('content')
    <div  class="container px-4 py-5">
        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-4 fw-bold lh-1 mb-3">
                    The AI-powered <span class="text-primary">blog</span>
                </h1>
                <p class="col-lg-10 fs-4">
                    The AI news reader is a new tool that can be used by anyone, without any cost. It is an artificial intelligence assistant that will read the news for you and provide you with relevant information.
                </p>
            </div>
            <div class="col-md-10 mx-auto col-lg-6">
                <form class="p-4 p-md-4 border rounded-3 bg-light" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-12">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   placeholder="Password"
                                   autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input id="password-confirm" type="password" class="form-control"
                                   placeholder="Confirm Password"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="w-100 btn btn-lg btn-primary">
                                {{ __('Sign up') }}
                            </button>
                        </div>
                        <hr class="my-4">
                        <small class="text-muted">By clicking Sign up, you agree to the <a href="{{ route('website.terms') }}">terms of use</a> </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
