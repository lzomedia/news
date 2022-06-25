@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="row">
            <div class="col-md-12">

                @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">:message</div>')) !!}
                @endif

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

            </div>

        </div>

        <div class="row justify-content-center">

            @include('partials.dashboard.sidebar')

            <div class="col-md-10">
                <div class="card">
                    {{$dataTable->table()}}
                </div>
            </div>
        </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
