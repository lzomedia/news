<?php

namespace App\Factories;

use App\Contracts\ArticleContract;
use App\Jobs\ProcessFeeds;

class ExtractorFactory
{
    private const DELAY = 10;

    public static function extract(int $feedID, ArticleContract $articleContract): void
    {
        $timeToWait = now()->addSeconds(self::DELAY);

        dispatch(new ProcessFeeds($feedID, $articleContract))->delay($timeToWait);
    }
}
