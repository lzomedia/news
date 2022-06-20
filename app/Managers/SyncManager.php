<?php

namespace App\Managers;

use App\Contracts\SyncContract;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;

class SyncManager implements SyncContract
{

    public function syncSingle(Feed $feed): void
    {
        $feed->sync = now();
        ProcessFeeds::dispatch($feed);
        $feed->save();
    }

    public function syncAll(): void
    {
        Feed::all()->each(function (Feed $feed) {
            $this->syncSingle($feed);
        });
    }
}
