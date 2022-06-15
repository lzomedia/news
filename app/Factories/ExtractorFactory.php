<?php

namespace App\Factories;

use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JsonException;


use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class ExtractorFactory
{
    public static function extract(string $url): void
    {
        dispatch(new ProcessFeeds($url));
    }
}
