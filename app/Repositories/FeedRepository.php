<?php

namespace App\Repositories;

use App\Contracts\FeedContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Models\Feed;
use App\Parsers\OpmlParser;
use App\Requests\SaveFileRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FeedRepository implements FeedContract
{
    protected UserContract $userContract;


    public function __construct(UserContract $userContract)
    {
        $this->userContract = $userContract;
    }

    public function getFeedById(int $feedId): mixed
    {
        return Feed::find($feedId);
    }

    public function deleteFeed(Feed | Model $feed): bool
    {
        return $feed->delete();
    }

    public function createFeed(array $feed): mixed
    {
        return Feed::firstOrCreate($feed);
    }

    public function getAllFeeds(UserContract $userContract): Collection
    {
        if ($userContract->getUserId() === null) {
            return Feed::all();
        }

        return Feed::where('user_id', $userContract->getUserId())->get();
    }

}
