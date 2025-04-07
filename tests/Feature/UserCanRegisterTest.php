<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCanRegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/api/user/register', [
            'name' => 'João',
            'email' => 'joao@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'joao@example.com']);
    }
}
