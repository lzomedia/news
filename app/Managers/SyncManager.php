<?php

namespace App\Managers;

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

    public function syncSingle(int $feed_id, int $article_id): bool
    {
        if ($this->feedContract->getFeedById($feed_id) === null) {
            return false;
        }

        $this->feedContract->getFeedById($feed_id)->sync = now();

        $this->feedContract->getFeedById($feed_id)->status = Feed::SYNCYING;

        ExtractorFactory::extract($feed_id, $this->articleContract);
        //todo improve this
        return ($this->feedContract->getFeedById($feed_id))->save();
    }

    public function syncAll(UserContract $userContract): bool
    {
        Feed::where('user_id', $userContract->getUserId())
            ->orderBy('id')->chunk(
                3, function ($feeds) {
                    foreach ($feeds as $feed) {
                        ExtractorFactory::extract($feed->id, $this->articleContract);
                    }
                }
            );

        return true;
    }
}
