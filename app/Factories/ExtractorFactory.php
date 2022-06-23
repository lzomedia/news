<?php

namespace App\Factories;

use App\Contracts\ArticleContract;
use App\Jobs\ProcessFeeds;

class ExtractorFactory
{
    private const DelayInSeconds = 60;

    public static function extract(int $feed_id, ArticleContract $articleContract): void
    {
        $timeToWait = now()->addSeconds(self::DelayInSeconds);

        dispatch(new ProcessFeeds($feed_id, $articleContract))->delay($timeToWait);
    }
}
