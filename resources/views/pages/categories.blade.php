@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <div class="row" data-masonry='{"percentPosition": true }'>

            @foreach($categories as $category)
                <?php
                $article = App\Models\Article::orderBy('id', 'desc')->where('category_id', $category->id)->first();
                ?>
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card bg-primary text-white text-center mb-3">

                        <img alt="{{ $article->title }}" src="{{ $article->image }}" class="bd-placeholder-img card-img-top" width="100%" height="200">

                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $category->name }}
                            </h5>
                        <p class="card-text">
                            {{ Str::words($article->summary, 5) }}
                        </p>
                    </div>
                </div>
                </div>
            @endforeach

        </div>

    </div>
    <!-- Footer-->

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
            integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"
            async></script>

@endsection
