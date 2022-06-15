<?php

namespace App\Console\Commands;

use App\Factories\ExtractorFactory;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use Illuminate\Console\Command;

class Processor extends Command
{
    protected $signature = 'processor:run';

    protected $description = 'This command will run and extract the data from the feeds';


    public function handle(): void
    {
        $feeds = Feed::all();

        $this->info('Start processing of feeds...');

        $this->output->progressStart($feeds->count());

        $feeds->each(function ($feed) {

            $this->output->progressAdvance();

            if(!$this->hasBeenSyncInLastHour($feed))
            {

                $this->processFeed($feed);

            }

        });

        $this->output->progressFinish();

        $this->info('Processing of feeds finished & jobs where dispatched.');
    }

    private function processFeed(Feed $feed): void
    {
        $feed->sync = now();

        dispatch(new ProcessFeeds($feed->url));

        $this->info('Processing of feed: ' . $feed->url);

        $feed->save();
    }

    private function hasBeenSyncInLastHour(Feed $feed): bool
    {
        return $feed->sync->diffInMinutes() < 1;
    }
}
