@extends('layouts.app')

@section('content')

    <div class="container-fluid py-2">
        <!-- Side widgets-->
        <div class="row">

            @include('partials.frontend.left-sidebar')

            <!-- Articles !-->
            <div class="col-lg-8">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home"
                                type="button" role="tab" aria-controls="nav-home" aria-selected="true">Latest
                        </button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Top
                        </button>

                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">


                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div id="home"></div>
                    </div>

                    <div class="tab-pane fade show " id="nav-profile" role="tabpanel" aria-labelledby="nav-home-tab">
                        @foreach($topArticles as $article)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <a href="{{ url("/") }}/articles/{{ $article->id .'/'. Str::slug($article->title) }}"
                                           title="{{ $article->title }}">{{ $article->title }}</a>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $article->excerpt }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
            <!-- Side widgets-->
            @include('partials.frontend.right-sidebar')
        </div>



    </div>

    </div>

@endsection
