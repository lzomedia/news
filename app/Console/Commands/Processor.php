<?php

namespace App\Console\Commands;

use App\Factories\ExtractorFactory;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use Illuminate\Console\Command;

class Processor extends Command
{
    protected $signature = 'processor:run {url}';

    protected $description = 'This command will run and extract the data from the feeds';


    public function handle(): void
    {

        $url = $this->argument('url');

        $feed = Feed::where('url', '=', $url)->get()->first();

        $feed->sync = now();

        dispatch(new ProcessFeeds($feed->url));

        $this->info('Processing of feed: ' . $feed->url);

        $feed->save();

        $this->info('Processing of feeds finished & jobs where dispatched.');
    }

}
