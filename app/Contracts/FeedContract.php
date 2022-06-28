<?php

namespace App\Contracts;

use App\Models\Feed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface FeedContract
{
    public function getFeedById(int $feedId): mixed;

    public function deleteFeed(Feed | Model $feed): bool | null;

    public function createFeed(array $feed): mixed;

    public function getAllFeeds(UserContract $userContract): Collection;

    public function getFeedsForUser(UserContract $userContract): Collection;
}
