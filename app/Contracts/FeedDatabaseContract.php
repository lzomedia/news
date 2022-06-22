<?php

namespace App\Contracts;

use App\Models\Feed;
use App\Models\User;
use App\Requests\SaveFileRequest;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\Article;


interface FeedDatabaseContract
{
    public function getFeedById(int $feedId): Feed | Model | null;

    public function deleteFeed(Feed | Model $feed): bool | null;

    public function createFeed(array $feed): Feed | Model;

    public function getAllFeeds(User | Authenticatable $user): Collection;
}
