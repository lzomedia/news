<?php

namespace Tests\Unit;

use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\Models\Feed;
use App\Models\User;
use App\Repositories\FeedRepository;
use App\Repositories\OldFeedsRepository;
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

        $userContract = $this->mock(UserContract::class)->shouldReceive('getUserId')->andReturn($user->id)->getMock();
        $manager = new FeedRepository($userContract);

        $manager->createFeed($data->toArray());
        $this->assertDatabaseHas('feeds', $data->toArray());
    }

    public function test_delete_feed(): void
    {
        $user = User::factory()->create();
        $data = collect([

            'title' => 'title',
            'url' => 'https://test.com',
            'sync' => Carbon::parse('2020-01-01')
        ]) ;
        $feed = Feed::factory()->create();

        $userContract = $this->mock(UserContract::class)->shouldReceive('getUserId')->andReturn($user->id)->getMock();
        $manager = new FeedRepository($userContract);
        $manager->deleteFeed($feed);
        $this->assertDatabaseMissing('feeds', $feed->toArray());
    }


    /**
     * @return void
     */
    public function test_can_view_all_feeds(): void
    {
        $user = User::factory()->create();


        $userContract = $this->mock(UserContract::class)->shouldReceive('getUserId')->andReturn($user->id)->getMock();
        $manager = new FeedRepository($userContract);

        $data = collect([
            'user_id' => 1,
            'title' => 'title',
            'url' => 'https://test.com',
            'sync' => Carbon::parse('2020-01-01')
        ]);

        $manager->createFeed($data->toArray());

        $feeds = $manager->getAllFeeds($userContract);

        $this->assertCount(1, $feeds);

    }
}
