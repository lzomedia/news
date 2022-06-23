<?php

namespace App\Console\Commands;

use App\Contracts\ArticleContract;
use App\DTO\Article;

use App\Jobs\DiscoverFeeds;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class FeedFinder extends Command
{
    protected $signature = 'feed:find {url}';

    protected $description = 'This command will run and extract the data from the feeds';


    public function handle(): void
    {
        $url = $this->argument('url');

        dispatch(new DiscoverFeeds($url));

        $this->info('Processing of feeds finished & jobs where dispatched.');
    }
}
