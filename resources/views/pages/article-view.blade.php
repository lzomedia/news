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
                    <img class="card-img-top h-100" src="{{ $article->image }}" alt="{{ $article->title }}">
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

                    <section class="mb-5">
                        <div id="disqus_thread"></div>
                        <script>
                            var disqus_config = function () {
                                this.page.url = '<?php echo URL::current();?>';
                                this.page.identifier = '<?php echo md5(URL::current());?>';
                            };
                            (function() { // DON'T EDIT BELOW THIS LINE
                                var d = document, s = d.createElement('script');
                                s.src = 'https://developmentsh.disqus.com/embed.js';
                                s.setAttribute('data-timestamp', +new Date());
                                (d.head || d.body).appendChild(s);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

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
