<?php

namespace App\Managers;

use App\Contracts\ArticleDatabaseContract;
use App\Contracts\SyncContract;
use App\Enums\FeedStatus;
use App\Factories\ExtractorFactory;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;

class SyncManager implements SyncContract
{

    public ArticleDatabaseContract $articleDatabaseContract;

    public function __construct(ArticleDatabaseContract $articleDatabaseContract)
    {
        $this->articleDatabaseContract = $articleDatabaseContract;
    }

    public function syncSingle(Feed | Model $feed, User| Authenticatable $user): bool
    {
        $feed->sync = now();
        $feed->status = Feed::SYNCYING;
        ExtractorFactory::extract($feed, $this->articleDatabaseContract);
        return $feed->save();
    }

    public function syncAll(User|Authenticatable $user): bool
    {

        $articleContract = $this->articleDatabaseContract;

        //todo check if user has feeds


        Feed::where('user_id', $user->id)->orderBy('id')->chunk(3, function ($feeds){

            foreach ($feeds as $feed)
            {
                ExtractorFactory::extract($feed, $this->articleDatabaseContract);
            }

        });

        return true;
    }
}
