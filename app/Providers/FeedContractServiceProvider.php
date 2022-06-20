<?php

namespace App\Providers;

use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;
use App\Contracts\SyncContract;
use App\Managers\SyncManager;
use App\Models\Feed;
use App\Repositories\FeedRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Development\Repositories\ArticleRepository;

class FeedContractServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FeedDatabaseContract::class, FeedRepository::class);
        $this->app->bind(SyncContract::class, SyncManager::class);
    }
}
