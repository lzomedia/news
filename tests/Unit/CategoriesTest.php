<?php

namespace Tests\Unit;

use App\Contracts\CategoryContract;
use App\Contracts\SyncContract;
use App\Jobs\ProcessFeeds;
use App\Models\Article;
use App\Models\ArticleReactions;
use App\Models\Category;
use App\Models\Feed;
use App\Models\User;
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
        $category =  Category::factory()->create();;

        $response  = $this->mock(CategoryContract::class)->shouldReceive('delete')->andReturn(
            Category::where('id', $category->id)->delete()
        )->getMock();
        $this->assertEquals(1, $response->delete($category->id));
    }

    public function test_can_find_category_by_name(): void
    {
        $category =  Category::factory()->create();;

        $response  = $this->mock(CategoryContract::class)->shouldReceive('findByName')->andReturn(
            Category::where('name', $category->name)->first()
        )->getMock();
        $this->assertEquals($category->name, $response->findByName($category->name)->name);
    }
}
