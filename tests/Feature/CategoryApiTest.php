<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    public function test_can_see_category_api(): void
    {
        $response = $this->get('api/v1/categories');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => []
        ]);
    }


    public function test_can_find_category_by_name(): void
    {
        $category = Category::factory()->create([
            'name' => 'test'
        ]);

        $response = $this->get('api/v1/categories/find/' . $category->name);
        $response->assertStatus(200);
    }
}
