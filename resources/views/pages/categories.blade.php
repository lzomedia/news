@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <a href="{{ route("categories.view") }}" title="categories">
                                Our top categories
                            </a>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            We have picked out our <b>best articles</b> in the <b>different categories</b> to help you
                            find what you are looking for.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row" data-masonry='{"percentPosition": true }'>
            @foreach($categories as $category)
                <?php
                $article = App\Models\Article::orderBy('id', 'desc')->where('category_id', $category->id)->first();
                ?>
                @if($article !==null)
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <a href="{{ url("/") }}/articles/{{ $article->id .'/'. Str::slug($article->title) }}"
                           class="text-white"
                           title="{{ $article->title }}">
                        <div class="card bg-primary text-white text-center mb-3">

                            <img alt="{{ $article->title }}" src="{{ $article->image }}"
                                 class="bd-placeholder-img card-img-top" width="100%" height="200">

                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $category->name }}
                                </h5>
                                <p class="card-text">
                                    {{ Str::words($article->summary, 10) }}
                                </p>
                            </div>
                        </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12 mb-5 mt-5">
                <div class="text-center">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
        @endsection
        @section('scripts')
            <script src="{{ asset('js/bootstrap.js') }}"></script>
            <script src="{{ asset('js/app.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
                    integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D"
                    crossorigin="anonymous"
                    async></script>

@endsection
