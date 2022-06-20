<?php

namespace Tests\Feature;

use App\DTO\Article;
use App\Factories\ExtractorFactory;
use App\Jobs\ProcessFeeds;
use App\Repositories\FeedRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;

class FeedsTest extends TestCase
{

    public function test_create_feed(): void
    {

        $data = collect([
            'user_id' => 1,
            'title' => 'title',
            'url' => 'https://test.com',
            'sync' => Carbon::parse('2020-01-01')
        ]) ;

        $manager = new FeedRepository();

        $manager->createFeed($data->toArray());
        $this->assertDatabaseHas('feeds', $data->toArray());

    }

    public function test_delete_feed(): void
    {
        $manager = new FeedRepository();
        $manager->deleteFeed(1);
        $this->assertDatabaseMissing('feeds', ['id' => 1]);
    }

    public function test_delete_all(): void
    {
        $manager = new FeedRepository();
        $manager->deleteAll();
        $this->assertDatabaseCount('feeds', 0);
    }

}
