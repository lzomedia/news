@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
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
                    <!-- Preview image figure-->
                    <figure class="mb-4" style="width: 100%">
                        <img style="width: 100%" class="rounded" src="{{ $article->image }}" alt="{{ $article->title }}">
                    </figure>
                    <!-- Post content-->
                    <section class="mb-5">
                        <p class="fs-5 mb-4">
                            {!!  $article->content !!}
                        </p>
                    </section>
                </article>
            </div>
            <!-- Side widgets-->
           @include('partials.frontend.sidebar')
        </div>

    </div>
    <!-- Footer-->

@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/default.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <!-- and it's easy to individually load additional languages -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/languages/go.min.js"></script>
    <script>hljs.highlightAll();</script>

@endpush
