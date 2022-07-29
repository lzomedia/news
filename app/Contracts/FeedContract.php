<?php

namespace App\Contracts;

use App\Models\Feed;
use App\Requests\SaveFileRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface FeedContract
{
    public function getFeedById(int $feedId): mixed;

    public function deleteFeed(Feed $feed): bool;

    public function createFeed(array $feed): mixed;

    public function getAllFeeds(UserContract $userContract): Collection;
}
