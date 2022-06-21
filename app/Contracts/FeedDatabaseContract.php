<?php

namespace App\Contracts;

use App\Models\Feed;
use App\Requests\SaveFileRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\Article;


interface FeedDatabaseContract
{
    public function getFeedById(int $feedId): Feed | Model;
    public function deleteFeed(Feed | Model $feed): bool;
    public function importFeeds(Collection $feeds): void;
    public function createFeed(array $feed): Feed | Model;
    public function getAllFeeds(): Collection;
}
