<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid align-content-end">
        <div class="row">

            <div class="col-lg-4">

                <a class="navbar-brand" href="{{ route('website.homepage') }}">
                    {{ config('app.name', 'News Reader') }}
                </a>
            </div>

            <div class="col-lg-4">

            </div>

            <div class="col-lg-4">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>

                <div class="collapse navbar-collapse pull-right" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 pull-right">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('website.about') }}">{{ __('About') }}</a>
                        </li>
                    </ul>
                </div>

            </div>


        </div>
    </div>
</nav>
