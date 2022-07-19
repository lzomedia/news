<?php

namespace App\Console\Commands;

use App\Contracts\ArticleContract;
use App\Contracts\FeedContract;
use App\Factories\ExtractorFactory;
use App\Jobs\DiscoverFeeds;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use Illuminate\Console\Command;

class ContentExtractor extends Command
{
    public FeedContract $feedContract;

    public ArticleContract $articleContract;

    protected $signature = 'content:extractor';

    protected $description = 'This command will extract the latest articles from all the feeds in the database';

    public function __construct(FeedContract $feedContract, ArticleContract $articleContract)
    {
        parent::__construct();

        $this->feedContract = $feedContract;

        $this->articleContract = $articleContract;
    }

    public function handle(): void
    {
        $this->info('We have started the content extraction process');
        $feeds = Feed::all();
        foreach ($feeds as $feed) {

            $this->feedContract->getFeedById($feed->id)->status = Feed::SYNCYING;
            dispatch(new ProcessFeeds($feed->id, $this->articleContract))->delay(30);
            ($this->feedContract->getFeedById($feed->id))->save();
        }
    }

}
