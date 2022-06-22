<?php

namespace App\Providers;

use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Managers\SyncManager;
use App\Repositories\ArticleRepository;
use App\Repositories\FeedRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(FeedDatabaseContract::class, FeedRepository::class);
        $this->app->bind(SyncContract::class, SyncManager::class);
        $this->app->bind(ArticleDatabaseContract::class, ArticleRepository::class);
        $this->app->bind(UserContract::class, UserRepository::class);

    }

    public function boot(): void
    {
    }
}
