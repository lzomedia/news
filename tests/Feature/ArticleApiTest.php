<?php

namespace Tests\Feature;

use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    public function test_can_see_articles_endpoint(): void
    {
        $response = $this->get('/v1/articles');
        $response->assertStatus(200);
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
