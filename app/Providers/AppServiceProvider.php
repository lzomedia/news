<?php

namespace App\Providers;

use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Contracts\VideoGeneratorContract;
use App\Managers\SyncManager;
use App\Managers\VideoGeneratorManager;
use App\Repositories\ArticleRepository;
use App\Repositories\FeedRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{


    public function register(): void
    {
        //Repositories
        $this->app->bind(FeedDatabaseContract::class, FeedRepository::class);
        $this->app->bind(ArticleDatabaseContract::class, ArticleRepository::class);
        $this->app->bind(UserContract::class, UserRepository::class);


        //Managers
        $this->app->bind(SyncContract::class, SyncManager::class);
        $this->app->bind(VideoGeneratorContract::class, VideoGeneratorManager::class);

    }

    public function boot(): void
    {
    }
}
