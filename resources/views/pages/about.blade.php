@extends('layouts.app')

@section('content')
    <div class="container-fluid bg-light">
        <div class="container">
            <div class="row pt-5 pb-5">
                <div class="col-md-12">
                    <h1>
                        Ai-powered news analysis
                    </h1>
                    <h2 class="fs-5 mb-5">
                        Development.sh is an ai-powered news reader that pulls in and dissects the content of your
                        favorite news channels. It then provides you with a personalized article feed based on your
                        interests.
                    </h2>

                    <div class="mb-5">
                        <a href="{{ url('register') }}" class="btn btn-primary btn-lg px-4">
                            Launch the app and start reading!
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="feature col">
                <h3 class="text-center">
                    AI for your day
                </h3>
                <p>
                    Whether you are a <b>busy professional</b> or a stay-at-home parent, Development.sh will provide you with the
                    latest business and lifestyle updates in your area of interest, so you never have to worry about
                    missing out on anything.
                </p>
            </div>
            <div class="feature col">
                <h3 class="text-center">
                    Enjoy the content
                </h3>
                <p>
                    Development.sh <b>is built by engineers</b> with AI expertise to deliver the best quality and breadth of
                    content in one place. You can enjoy <b>reading the latest articles from CNN, BBC, Reuters</b> and more -
                    all conveniently in one place!
                </p>
            </div>
            <div class="feature col">
                <h3 class="text-center">
                    Recommendations
                </h3>
                <p>
                    A <b>powerful recommendation engine</b> uses machine learning to identify your preferences based on
                    articles you read and topics you're interested in - helping us recommend only the <b>most relevant
                        news</b> to you.
                </p>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-light">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="py-5 text-center">
                            <h2>
                                Give News Bot a try today
                            </h2>
                            <p class="lead">
                                The <b>AI news reader</b> is a new tool that can be used to create and share
                                personalized news.

                                It is free and easy to use.

                                It is currently in beta stage and it will be available for everyone soon.

                                You can test the AI news reader now without any cost.
                            </p>
                        </div>
                    </div>
                   <div id="news-bot"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/newsBot.js') }}"></script>
@endsection
