@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                @foreach($categories as $category)
                    {{ $category->name }} <br>
                @endforeach
            </div>
            <!-- Side widgets-->
           @include('partials.frontend.sidebar')
        </div>

    </div>
    <!-- Footer-->

@endsection
