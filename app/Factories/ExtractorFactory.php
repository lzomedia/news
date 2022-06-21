<?php

namespace App\Factories;

use App\Contracts\ArticleDatabaseContract;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;



use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class ExtractorFactory
{
    public static function extract(
        Feed | Model $feed,
        ArticleDatabaseContract $articleDatabaseContract
    ): void
    {
        dispatch(new ProcessFeeds($feed, $articleDatabaseContract))
            ->delay(now()
                ->addSeconds(10));
    }
}
