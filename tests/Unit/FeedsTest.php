<?php

namespace Tests\Unit;

use App\Contracts\SyncContract;
use App\Repositories\FeedRepository;
use Carbon\Carbon;
use Mockery;
use Tests\TestCase;

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
        $data = collect([

            'title' => 'title',
            'url' => 'https://test.com',
            'sync' => Carbon::parse('2020-01-01')
        ]) ;
        $manager = new FeedRepository();
        $feed = $manager->createFeed($data->toArray());

        $manager->deleteFeed($feed);
        $this->assertDatabaseMissing('feeds', $feed->toArray());

    }



    public function test_can_view_all_feeds(): void
    {
        $data = collect([
            'user_id' => 1,
            'title' => 'title',
            'url' => 'https://test.com',
            'sync' => Carbon::parse('2020-01-01')
        ]) ;
        $manager = new FeedRepository();
        $manager->createFeed($data->toArray());


        $feeds = $manager->getAllFeeds();
        $this->assertCount(1, $feeds);
    }

    public function test_if_can_import_single()
    {

        $data = collect([
            'user_id' => 1,
            'title' => 'title',
            'url' => 'https://test.com',
            'sync' => Carbon::parse('2020-01-01')
        ]) ;

        $manager = new FeedRepository();
        $feed = $manager->createFeed($data->toArray());

        $mock = Mockery::mock(SyncContract::class);
        $mock->shouldReceive('syncSingle')->withArgs([$feed])->andReturn(true);
        $response = $mock->syncSingle($feed);

        $this->app->instance(SyncContract::class, $mock);
        $this->assertTrue( $response);


    }


}
