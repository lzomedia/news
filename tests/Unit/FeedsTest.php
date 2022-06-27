<?php

namespace Tests\Unit;

use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Models\Feed;
use App\Models\User;
use App\Repositories\FeedRepository;
use Carbon\Carbon;
use Mockery;
use Tests\TestCase;

class FeedsTest extends TestCase
{
    public function test_create_feed(): void
    {
        $user = User::factory()->create();

        $data = collect([
            'user_id' => $user->id,
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
        $feed = Feed::factory()->create();
        $manager = new FeedRepository();
        $manager->deleteFeed($feed);
        $this->assertDatabaseMissing('feeds', $feed->toArray());
    }


    /**
     * @return void
     */
    public function test_can_view_all_feeds(): void
    {
//        $userContract = Mockery::mock(UserContract::class);
//
//        $user = new \App\Models\User();
//
//        $user->id = 1;
//
//        $userContract->shouldReceive('getUserById')->once()->andReturn($user);
//
//        $data = collect([
//            'user_id' => 1,
//            'title' => 'title',
//            'url' => 'https://test.com',
//            'sync' => Carbon::parse('2020-01-01')
//        ]);
//
//        $manager = new FeedRepository();
//
//        $manager->createFeed($data->toArray());
//
//        $feeds = $manager->getAllFeeds($userContract);
//
//        $this->assertCount(3, $feeds);

        $this->markTestSkipped('This test has not been implemented yet.');
    }

    public function test_if_can_import_single(): void
    {
//        $data = collect([
//            'user_id' => 1,
//            'title' => 'title',
//            'url' => 'https://test.com',
//            'sync' => Carbon::parse('2020-01-01')
//        ]) ;
//
//        $manager = new FeedRepository();
//
//        $feed = $manager->createFeed($data->toArray());
//
//        $mock = Mockery::mock(SyncContract::class);
//
//        $mock->shouldReceive('syncSingle')->withArgs([$feed])->andReturn(true);
//
//        $response = $mock->syncSingle($feed);
//
//        $this->app->instance(SyncContract::class, $mock);
//
//        $this->assertTrue($response);

        $this->markTestSkipped('This test has not been implemented yet.');
    }
}
