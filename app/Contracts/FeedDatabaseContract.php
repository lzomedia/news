<?php

namespace App\Contracts;

use App\Models\Feed;
use App\Requests\SaveFileRequest;
use Illuminate\Support\Collection;
use App\Models\Article;


interface FeedDatabaseContract
{
    public function getFeedById(int $feedId): Feed;
    public function getAllFeeds(): Collection;
    public function deleteFeed(Feed $feed): ?bool;
    public function deleteAll():void;
    public function importFeeds(Collection $feeds): void;
    public function createFeed(array $feed): ?Feed;
}
