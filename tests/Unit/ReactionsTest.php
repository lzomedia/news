<?php

namespace Tests\Unit;

use App\Contracts\SyncContract;
use App\Jobs\ProcessFeeds;
use App\Models\Article;
use App\Models\ArticleReactions;
use App\Models\Feed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ReactionsTest extends TestCase
{
    public function test_get_reactions_by_article_id(): void
    {
        //@todo implement this
        $this->markTestSkipped('to implement this');
    }
}
