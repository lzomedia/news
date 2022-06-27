<?php

namespace App\Services;

use App\Contracts\ArticleContract;
use App\Contracts\FeedContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Factories\ExtractorFactory;
use App\Models\Feed;

class SyncManager implements SyncContract
{
    private FeedContract $feedContract;

    private ArticleContract $articleContract;

    public function __construct(FeedContract $feedContract, ArticleContract $articleContract)
    {
        $this->feedContract = $feedContract;

        $this->articleContract = $articleContract;
    }

    public function syncSingle(int $feedID, int $articleID): bool
    {
        if ($this->feedContract->getFeedById($feedID) === null) {
            return false;
        }

        $this->feedContract->getFeedById($feedID)->sync = now();

        $this->feedContract->getFeedById($feedID)->status = Feed::SYNCYING;

        ExtractorFactory::extract($feedID, $this->articleContract);

        return ($this->feedContract->getFeedById($feedID))->save();
    }

    public function syncAll(UserContract $userContract): bool
    {
        Feed::where('user_id', $userContract->getUserId())
            ->orderBy('id')->chunk(
                3,
                function ($feeds) {
                    foreach ($feeds as $feed) {
                        $this->feedContract->getFeedById($feed->id)->status = Feed::SYNCYING;
                        ExtractorFactory::extract($feed->id, $this->articleContract);
                        ($this->feedContract->getFeedById($feed->id))->save();
                    }
                }
            );

        return true;
    }
}
