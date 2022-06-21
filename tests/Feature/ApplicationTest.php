<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_see_homepage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
//        $response->assertViewHas('Welcome to News Reader!');
    }
}
