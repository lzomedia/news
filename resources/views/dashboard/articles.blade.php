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
                    <div class="card-header">
                        <h4 class="card-title">
                            Articles
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ Str::words($article->title, 8) }}</td>
                                    <td>
                                        <a href="{{ route('video.generate', $article->id) }}" class="btn btn-primary">
                                            Generate Video
                                        </a>
                                        <a href="{{ route('video.generate', $article->id) }}" class="btn btn-success">
                                            Rewrite
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
