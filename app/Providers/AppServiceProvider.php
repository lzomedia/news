<?php

namespace App\Providers;

use App\Contracts\ArticleContract;
use App\Contracts\CategoryContract;
use App\Contracts\FeedContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Contracts\VideoContract;
use App\Managers\SyncManager;
use App\Managers\VideoManager;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FeedRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Repositories
        $this->app->bind(FeedContract::class, FeedRepository::class);
        $this->app->bind(ArticleContract::class, ArticleRepository::class);
        $this->app->bind(UserContract::class, UserRepository::class);
        $this->app->bind(CategoryContract::class, CategoryRepository::class);


        //Managers
        $this->app->bind(SyncContract::class, SyncManager::class);
        $this->app->bind(VideoContract::class, VideoManager::class);
    }

}
