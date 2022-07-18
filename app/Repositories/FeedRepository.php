<?php

namespace App\Repositories;

use App\Contracts\FeedContract;
use App\Contracts\UserContract;
use App\Models\Feed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FeedRepository implements FeedContract
{
    public function getFeedById(int $feedId): mixed
    {
        return Feed::find($feedId);
    }

    public function getAllFeeds(UserContract $userContract): Collection
    {
        return Feed::where('user_id', $userContract->getUserId())->get();
    }

    public function deleteFeed(Feed | Model $feed): bool
    {
        return $feed->delete();
    }

    public function createFeed(array $feed): mixed
    {
        return Feed::firstOrCreate($feed);
    }

    public function getFeedsForUser(UserContract $userContract): Collection
    {
        return Feed::where('user_id', $userContract->getUserId())->get();
    }
}
