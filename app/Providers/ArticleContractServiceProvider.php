<?php

namespace App\Providers;

use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;
use Illuminate\Support\ServiceProvider;
use Modules\Development\Repositories\ArticleRepository;

class ArticleContractServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ArticleDatabaseContract::class, \App\Repositories\ArticleRepository::class);
    }
}
