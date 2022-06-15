<?php

namespace Tests\Feature;

use App\Factories\ExtractorFactory;
use App\Jobs\ProcessFeeds;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;

class FactoriesTest extends TestCase
{

    public function testCanRunExtractor(): void
    {

        Queue::fake();

        ExtractorFactory::extract('');

        Queue::assertPushed(ProcessFeeds::class, static function ($job) {
            return strlen($job->message) < 140;
        });
    }
}
