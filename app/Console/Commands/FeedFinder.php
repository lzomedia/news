<?php

namespace App\Console\Commands;

use App\Contracts\ArticleContract;
use App\DTO\Article;

use App\Jobs\DiscoverFeeds;
use App\Models\Feed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class FeedFinder extends Command
{
    protected $signature = 'feed:find {url}';

    protected $description = 'This command will run and try to find others feeds to parse from the content';


    public function handle(): void
    {
        $url = $this->argument('url');

        $this->info('Feeds are being discovered');

        dispatch(new DiscoverFeeds($url));

        $this->info('Feeds have been discovered');

    }
}
