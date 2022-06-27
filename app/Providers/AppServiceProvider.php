<?php

namespace App\Providers;

use App\Contracts\ArticleContract;
use App\Contracts\CategoryContract;
use App\Contracts\FeedContract;
use App\Contracts\SyncContract;
use App\Contracts\TextRewriterContract;
use App\Contracts\UserContract;
use App\Contracts\VideoContract;
use App\Jobs\ProcessFeeds;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FeedRepository;
use App\Repositories\UserRepository;
use App\Services\SyncManager;
use App\Services\TextRewriterManager;
use App\Services\VideoManager;
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
        $this->app->bind(TextRewriterContract::class, TextRewriterManager::class);

        $this->app->when(ProcessFeeds::class)
            ->needs(ArticleContract::class)
            ->give(function () {
                return new ArticleRepository();
            });

    }

}
