<?php

namespace App\Providers;

use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;
use App\Contracts\SyncContract;
use App\Managers\SyncManager;
use App\Repositories\ArticleRepository;
use App\Repositories\FeedRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(FeedDatabaseContract::class, FeedRepository::class);
        $this->app->bind(SyncContract::class, SyncManager::class);
        $this->app->bind(ArticleDatabaseContract::class, ArticleRepository::class);

    }

    public function boot(): void
    {
    }
}
