@extends('layouts.app')

@section('content')

    <div class="container py-5">

        @include('partials.dashboard.errors')

        <div class="row justify-content-center">

            @include('partials.dashboard.sidebar')

            <div class="col-md-10">
                <div class="row">
                    <div class="container">
                        <div id="CategoriesApp"></div>
                    </div>
                </div>

            </div>

        </div>

        @endsection

@section('scripts')
     <script src="{{ asset('js/CategoriesApp.js') }}"></script>
@endsection
