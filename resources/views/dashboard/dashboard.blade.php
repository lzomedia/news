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



            <div class="col-md-10">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Feeds
                        </h4>
                    </div>
                    <div class="card-body">


                        @if(count($feeds) > 0):
                            <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>

                                <th scope="col">Status</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($feeds as $feed)
                                <tr>
                                    <th scope="row">{{ $feed->id }}</th>
                                    <td>
                                        <a target="_blank" href="{{ $feed->url }}">
                                            {{ $feed->title }}
                                        </a>
                                    </td>

                                    <td>{{ $feed->status }}</td>
                                    <td>
                                        <a href="{{ route('feeds.sync-single', $feed->id ) }}">
                                            Sync
                                        </a>
                                        /
                                        <a href="{{ route('video.generate', $feed->id ) }}">
                                            Make Video
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <div class="alert alert-danger" role="alert">
                                No feeds found.
                                Please use the form above to upload some feeds.
                            </div>
                        @endif
                    </div>
             </div>



        </div>
    </div>
@endsection
