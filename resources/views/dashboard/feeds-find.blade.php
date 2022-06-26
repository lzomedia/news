@extends('layouts.app')

@section('content')

    <div class="container py-5">

        @include('partials.dashboard.errors')

        <div class="row justify-content-center">

            @include('partials.dashboard.sidebar')

            <div class="col-md-10">
                <div id="findFeeds"></div>
            </div>

        </div>

@endsection

@push('scripts')
   <script src="{{ asset('js/findFeeds.js') }}"></script>
@endpush
