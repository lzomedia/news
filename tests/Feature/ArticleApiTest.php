<?php

namespace Tests\Feature;

use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    public function test_can_see_articles_endpoint(): void
    {
        $response = $this->get('api/v1/articles');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'success',
            'message',
            'categories',
            'result' => []
        ]);
    }
}
