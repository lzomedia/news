@extends('layouts.app')

@section('content')

    <div class="container py-5">

        @include('partials.dashboard.errors')

        <div class="row justify-content-center">

            @include('partials.dashboard.sidebar')

            <div class="col-md-10">

                <div class="card" style="margin-bottom: 5vh">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{ __('Video Generator') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="videoGenerator" v-demo="{ color: 'white', text: 'hello!' }">
                        </div>
                      </div>
                    </div>
                </div>

            </div>

        </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/videoGenerator.js') }}"></script>
@endpush
