@extends('layouts.app')
@section('content')
    <div class="container-fluid ">
        <div class="row">
            <!-- Side widgets-->
            @include('partials.article.left-sidebar')
            <!-- Article !-->
            <div class="col-lg-8 py-3">
                <!-- Preview image figure-->
                <figure class="mb-4" >
                    <img style="width: 100%;max-height:200px" class="rounded" src="{{ $article->image }}" alt="{{ $article->title }}">
                </figure>

                <!-- Post content-->
                <article>
                    <!-- Post header-->
                    <header class="mb-4">
                        <!-- Post title-->
                        <h1 class="fw-bolder mb-1">
                            {{ $article->title }}
                        </h1>
                        <div class="text-muted fst-italic mb-2">Posted on {{ $article->published_at }} by {{ $article->author }}</div>
                        <div class="text-muted fst-italic mb-2">Time to read 1 min </div>
                        <div class="text-muted fst-italic mb-2">
                            Sentiment of the text
                        </div>


                    @foreach($article->tags as $tag)
                            <a class="badge bg-secondary text-decoration-none link-light" href="">{{ $tag->name }}</a>
                        @endforeach
                    </header>


                    <!-- Post content-->
                    <section class="mb-5">
                        <p class="fs-5 mb-4">
                            {!!  $article->content !!}
                        </p>
                    </section>
                </article>
            </div>
            <!-- Side widgets-->
           @include('partials.article.right-sidebar')
        </div>
    </div>
@endsection
@push('scripts')
    <style>
        article img{
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
@endpush
