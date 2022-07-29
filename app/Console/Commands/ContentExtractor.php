<?php

namespace App\Console\Commands;

use App\Contracts\ArticleContract;
use App\Contracts\FeedContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Factories\ExtractorFactory;
use App\Jobs\DiscoverFeeds;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use Illuminate\Console\Command;

class ContentExtractor extends Command
{
    public FeedContract $feedContract;

    public ArticleContract $articleContract;

    public SyncContract $syncContract;

    public UserContract $userContract;

    protected $signature = 'content:extractor';

    protected $description = 'This command will extract the latest articles from all the feeds in the database';

    public function __construct(FeedContract $feedContract, ArticleContract $articleContract, SyncContract $syncContract, UserContract $userContract)
    {
        parent::__construct();

        $this->feedContract = $feedContract;
        $this->articleContract = $articleContract;
        $this->syncContract = $syncContract;
        $this->userContract = $userContract;
    }

    public function handle(): void
    {
        $this->info('We have started the content extraction process');
        $feeds = Feed::all();
        foreach ($feeds as $feed) {

            $this->feedContract->getFeedById($feed->id)->status = Feed::SYNCYING;
            dispatch(new ProcessFeeds($feed->id))->delay(30);
            ($this->feedContract->getFeedById($feed->id))->save();
        }
    }

}
