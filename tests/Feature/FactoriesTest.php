<?php

namespace Tests\Feature;

use App\Contracts\SyncContract;
use App\DTO\Article;
use App\Factories\ExtractorFactory;
use App\Jobs\ProcessFeeds;
use App\Jobs\SaveToDatabase;
use App\Models\Feed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;

class FactoriesTest extends TestCase
{

    public function testCanRunExtractor(): void
    {

        Queue::fake();

        $feed = new Feed([
            'title' => 'Test Feed',
            'url' => 'http://example.com/',
        ]);

        ExtractorFactory::extract($feed);

        Queue::assertPushed(ProcessFeeds::class, static function ($job) {
            return strlen($job->message) < 140;
        });
    }


}
