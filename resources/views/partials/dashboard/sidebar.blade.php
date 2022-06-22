<div class="col-md-2">
    <div class="card" bis_skin_checked="1">
        <div class="card-header">{{ __('Sidebar') }}</div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="{{ route('dashboard') }}">
                    Home
                </a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('feeds.sync-all') }}">
                    Sync
                </a>
            </li>
            <li class="list-group-item">
                <a href="{{ route('dashboard.articles') }}">
                    Articles
                </a>
            </li>
        </ul>
    </div>
</div>
