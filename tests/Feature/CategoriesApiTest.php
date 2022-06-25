<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoriesApiTest extends TestCase
{
    public function test_can_see_categories__endpoint(): void
    {
        $response = $this->get('api/v1/categories');
        $response->assertStatus(200);
    }
}
