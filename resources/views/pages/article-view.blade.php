@extends('layouts.app')
@section('content')
    <div class="container-fluid pt-3">

        <div class="row">

            <!-- Article !-->
            <div class="col-lg-9 py-3">
                <!-- Preview image figure-->
                <figure class="mb-4">
                    <img class="card-img-top h-100" src="{{ $article->image }}" alt="{{ $article->title }}">
                </figure>

                <!-- Post content-->
                <article>
                    <!-- Post header-->
                    <header class="mb-3">
                        <!-- Post title-->
                        <h1 class="fw-bolder mb-1" title="{{ $article->title }}">
                            <a href="<?php echo URL::current();?>" title="{{ $article->title }}">
                                {{ $article->title }}
                            </a>
                        </h1>
                        <!-- Post meta-->
                        <div class="text-muted fst-italic mb-2">
                            Posted on {{ $article->published_at }} by {{ $article->author }}
                        </div>

                        <div class="text-muted fst-italic mb-2">
                            Time to read {{ $reactions->timeToRead }} minutes
                        </div>
                        <div class="text-muted fst-italic mb-2">
                            <?php
                                $sentiment = json_decode($reactions->vader);
                                $sentiment =  ($sentiment->compound);
                            ?>

                            @if($sentiment > 0.5)
                                <p class="badge bg-success text-decoration-none link-light">
                                    Sentiment of the text is positive.
                                </p>

                            @elseif($sentiment < 0.5)
                                    <p class="badge bg-danger text-decoration-none link-light">
                                        Sentiment of the text is negative.
                                    </p>
                            @endif
                        </div>
                    </header>

                    <!-- Post tags-->
                    <section>
                        @foreach($article->tags as $tag)
                            <a class="badge bg-secondary text-decoration-none link-light"
                               title="articles about {{ $tag->name }}" href="#">#{{ $tag->name }}</a>
                        @endforeach
                    </section>

                    <!-- Post content-->
                    <section class="mb-5">
                        <p class="fs-5 mb-4">
                            {!!  $article->content !!}
                        </p>
                    </section>

                </article>

            </div>

            <!-- Side widgets-->
            <div class="col-lg-3 pt-3">
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Top Articles</div>
                    <div class="card-body">
                        @foreach($topArticles as $article)
                            <div class="media">
                                <img class="mr-3" src="{{ $article->image }}" alt="{{ $article->title }}" width="64" height="64">
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a href="{{ url("/") }}/articles/{{ $article->id .'/'. Str::slug($article->title) }}" title="{{ $article->title }}">
                                            {{ $article->title }}
                                        </a>
                                    </h5>
                                    <div class="text-muted fst-italic mb-2">
                                        {{ $article->published_at }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('scripts')
    <style>
        article img {
            max-width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
    <script>
        $(document).ready(function () {
            $("img.card-img-top").load(function () {
                console.log($(this).height());
                console.log($(this).width());
            });
        });
    </script>
@endpush
