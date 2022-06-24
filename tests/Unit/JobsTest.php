<?php

namespace Tests\Unit;

use App\Contracts\SyncContract;
use App\Jobs\ProcessFeeds;
use App\Models\Article;
use App\Models\Feed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class JobsTest extends TestCase
{
    public function testSyncSingle(): void
    {
        Queue::fake();
        $feed = new Feed();
        $feed->id = 1;
        $feed->title = 'title';
        $feed->url = 'https://test.com';
        $feed->sync = Carbon::parse('2020-01-01');


        $article = new Article();
        $article->id = 1;

        $sync = $this->app->make(SyncContract::class);

        $sync->syncSingle($feed->id, $article->id);

        Queue::assertPushed(ProcessFeeds::class, static function ($job) {
            return strlen($job->message) < 140;
        });
    }
}
