@extends('layouts.app')

@section('content')
    <div class="container">

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


            <div class="col-md-2">
                <div class="card" bis_skin_checked="1">
                    <div class="card-header">{{ __('Sidebar') }}</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a href="{{ route('feeds.sync-all') }}">
                                Sync All Now
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


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

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Feeds
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Url</th>
                                <th scope="col">Status</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($feeds as $feed)
                                <tr>
                                    <th scope="row">{{ $feed->id }}</th>
                                    <td>{{ $feed->title }}</td>
                                    <td>{{ $feed->url }}</td>
                                    <td>{{ $feed->status }}</td>
                                    <td>
                                        <a href="{{ route('feeds.sync-single', $feed->id ) }}">
                                            Sync
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
             </div>



        </div>
    </div>
@endsection
