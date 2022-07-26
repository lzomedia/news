@extends('layouts.app')
@section('content')

    <div class="container mt-5">
        <div class="row">
            @include('partials.dashboard.errors')
            <div class="row justify-content-center">
                @include('partials.dashboard.sidebar')
                {{ $slot }}
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @rapydLivewireStyles
    @rapydLivewireScripts
@endsection
