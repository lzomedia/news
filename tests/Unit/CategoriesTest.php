<?php

namespace Tests\Unit;

use App\Contracts\CategoryContract;
use App\Contracts\SyncContract;
use App\Jobs\ProcessFeeds;
use App\Models\Article;
use App\Models\ArticleReactions;
use App\Models\Category;
use App\Models\Feed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    public function test_get_categories(): void
    {
        $response  = $this->mock(CategoryContract::class)->shouldReceive('getAllCategories')->andReturn(
            Category::with('articles')->orderBy('count', 'desc')
        )->getMock();

        $this->assertInstanceOf(Collection::class, $response->getAllCategories()->get());

        $this->get('/api/v1/categories')->assertStatus(200);

    }


    public function test_can_delete_category(): void
    {

        $response  = $this->mock(CategoryContract::class)->shouldReceive('delete')->andReturn(
            Category::where('id', 1)->delete()
        )->getMock();
    }
}
