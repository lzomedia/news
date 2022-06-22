<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{

    public function test_can_see_homepage():void
    {
        $response = $this->get('/');
        $response->assertSeeText('News');
        $response->assertStatus(200);
    }

    public function test_can_see_register():void
    {

        $response = $this->get('/register');
        $response->assertSeeText('Register');
        $response->assertStatus(200);
    }

    public function test_can_see_login():void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSeeText('Login');
    }

    public function test_can_see_reset():void
    {
        $response = $this->get('/password/reset');
        $response->assertStatus(200);
        $response->assertSeeText('Send Password Reset Link');
    }

    public function a_user_can_register(): void
    {
        $user = [
            'name' => 'Joe',
            'email' => 'testemail@test.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest'
        ];

        $response = $this->post('/register', $user);

        $response->assertRedirect('/dashboard');
    }
}
