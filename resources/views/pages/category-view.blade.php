@extends('layouts.app')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row">

                @foreach($categories as $category)
                <div class="col-lg-3">
                    <div class="card mb-5" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ $category->name }}
                            </h5>
                            <p class="card-text">
                              <?php
                                    $article = App\Models\Article::orderBy('id', 'desc')->where('category_id', $category->id)->first();
                                    if(!is_null($article)){
                                        echo $article->title;
                                    }
                              ?>
                            </p>
                            <a href="#" class="card-link">Card link</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <!-- Footer-->

@endsection
