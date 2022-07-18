@extends('layouts.app')

@section('content')

    <div class="container-fluid py-2">

        <div class="row ">
            <!-- Side widgets-->
            @include('partials.frontend.left-sidebar')

            <!-- Articles !-->
            <div id="home" class="col-lg-8"></div>


            <!-- Side widgets-->
            @include('partials.frontend.right-sidebar')

        </div>

    </div>



@endsection
