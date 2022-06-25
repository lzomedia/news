@extends('layouts.app')

@section('content')
    <div class="container py-5">

       @include('partials.dashboard.errors')

        <div class="row justify-content-center">


          @include('partials.dashboard.sidebar')


            <div class="col-md-10">
                <div class="card" style="margin-bottom: 5vh">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <h2>
                            Welcome to the dashboard.
                        </h2>
                        <p>
                            Project created with &hearts; by
                            <a href="https://twitter.com/L70Media">@L70Media</a>
                        </p>
                        <p>
                            You can now head to the <a href="{{ route('dashboard.articles') }}">articles</a> section to see your articles.
                        </p>
                    </div>
                </div>


        </div>

    </div>
@endsection
