<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_authenticate_returns_token()
    {
        $response = $this->post('/api/authenticate', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    public function test_user_authenticate_cannot_return_correct_token_when_failed()
    {
        $response = $this->post('/api/authenticate', [
            'email' => 'test11@example.com',
            'password' => 'password23'
        ], ['Accept' => 'application/json']);

        $response->assertStatus(403);
    }
}
