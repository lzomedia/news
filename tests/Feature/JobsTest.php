<?php

namespace Tests\Feature;

use App\Contracts\SyncContract;
use App\DTO\Article;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class JobsTest extends TestCase
{

    public function testSyncSingle(): void
    {
        Queue::fake();


        $sync = $this->app->make(SyncContract::class);

        $sync->syncSingle(new Feed([
            'title' => 'Test Feed',
            'url' => 'http://example.com/',
        ]));

        Queue::assertPushed(ProcessFeeds::class, static function ($job) {
            return strlen($job->message) < 140;
        });

    }
}
