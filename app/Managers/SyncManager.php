<?php

namespace App\Managers;

use App\Contracts\ArticleDatabaseContract;
use App\Contracts\SyncContract;
use App\Enums\FeedStatus;
use App\Factories\ExtractorFactory;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SyncManager implements SyncContract
{

    public ArticleDatabaseContract $articleDatabaseContract;

    public function __construct(ArticleDatabaseContract $articleDatabaseContract)
    {
        $this->articleDatabaseContract = $articleDatabaseContract;
    }

    public function syncSingle(Feed | Model $feed): bool
    {
        $feed->sync = now();
        $feed->status = Feed::SYNCYING;
        ExtractorFactory::extract($feed, $this->articleDatabaseContract);
        return $feed->save();
    }

    public function syncAll(): bool
    {

        $articleContract = $this->articleDatabaseContract;

        Feed::orderBy('id')->chunk(3, function ($feeds) use ($articleContract){

            foreach ($feeds as $feed){
                ExtractorFactory::extract($feed, $articleContract);
            }
        });

        return true;
    }
}
