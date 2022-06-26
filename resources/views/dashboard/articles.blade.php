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
                            {{ __('Articles') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        {{$dataTable->table()}}
                    </div>
                </div>

            </div>

        </div>

@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
