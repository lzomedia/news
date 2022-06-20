<?php

namespace App\Repositories;

use App\Contracts\FeedDatabaseContract;
use App\Contracts\SyncContract;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use App\Parsers\OpmlParser;
use App\Requests\SaveFileRequest;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FeedRepository implements FeedDatabaseContract
{
    public function getFeedById(int $feedId): Feed
    {
        return (new \App\Models\Feed)->find($feedId);
    }

    public function getAllFeeds(): Collection
    {
       return Feed::all();
    }

    public function deleteFeed(Feed $feed): ?bool
    {
        return $feed->delete();
    }

    public function importFeeds(Collection $feeds): void
    {
        $feeds->each(function ($feed) {
            $this->createFeed($feed);
        });
    }

    public function createFeed(array $feed): ?Feed
    {
        return (new \App\Models\Feed)->create($feed);
    }
}
