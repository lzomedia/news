<?php

namespace App\Factories;

use App\Contracts\ArticleContract;
use App\Jobs\ProcessFeeds;

class ExtractorFactory
{
    private const DELAY = 30;

    public static function extract(int $feedID): void
    {
        $timeToWait = now()->addSeconds(self::DELAY);

        dispatch(new ProcessFeeds($feedID))->delay($timeToWait);
    }
}
