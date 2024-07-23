<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function it_allows_successful_login()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }
    public function it_rejects_unsuccessful_login()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/api/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Invalid credentials']);
    }
}
