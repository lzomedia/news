@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 pb-lg-5">
                <div class="cont_principal">
                    <div class="cont_error">
                        <h1>Oops</h1>
                        <p>
                            {{ $exception->getMessage() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Footer-->

@endsection
