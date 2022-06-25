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
                        <form action="{{ route('feeds.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex justify-center">
                                <div class="mb-3 w-96">
                                    <label for="formFile" class="form-label inline-block mb-2 text-gray-700">
                                        This should have the extension of .opml
                                    </label>
                                    <input name="file" class="form-control block w-full text-base transition ease-in-out m-0" type="file">
                                </div>
                                <div class="flex space-x-2 justify-center">
                                    <button type="submit" class="inline-block btn btn-primary">Upload</button>
                                </div>
                                <input type="hidden" name="user" value="{{  auth() -> user() }} ">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card" style="margin-bottom: 5vh">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{ __('Feeds') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <span>
                               <a href="{{ route('feeds.sync-all') }}">
                                Sync All Feeds
                            </a>
                        </span>
                        {{$dataTable->table()}}
                    </div>
                </div>

        </div>

    </div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush
