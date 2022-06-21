<?php

namespace App\Managers;

use App\Contracts\SyncContract;
use App\Enums\FeedStatus;
use App\Factories\ExtractorFactory;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;

class SyncManager implements SyncContract
{
    public function syncSingle(Feed $feed): bool
    {
        $feed->sync = now();
        $feed->status = Feed::SYNCYING;
        ExtractorFactory::extract($feed);
        return $feed->save();
    }

    public function syncAll(): bool
    {

        Feed::where('status', Feed::COMPLETED)->get()->each(function (Feed $feed) {
            ExtractorFactory::extract($feed);
        });

        return true;
    }
}
