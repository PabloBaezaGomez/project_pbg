<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Seed the database with test data
    }

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'user_name' => 'testuser',
            'user_email' => 'test@example.com',
            'user_password' => 'password123',
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'user' => ['user_id', 'user_name', 'user_email'],
                        'token'
                    ]
                ]);

        $this->assertDatabaseHas('users', [
            'user_name' => 'testuser',
            'user_email' => 'test@example.com',
        ]);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        // Use seeded user (Bob) with known password
        $response = $this->postJson('/api/login', [
            'email' => 'bob@example.com',
            'password' => 'password', // Password from seeder
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'token',
                    'user' => ['user_id', 'user_name', 'user_email']
                ]);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'bob@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422) // Laravel validation returns 422, not 401
                ->assertJsonValidationErrors(['email']);
    }

    public function test_authenticated_user_can_logout(): void
    {
        // Use seeded user
        $user = User::where('user_email', 'bob@example.com')->first();
        
        // Create token for user
        $token = $user->createToken('test-token')->plainTextToken;
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Logged out successfully' // Match actual controller response
                ]);
    }
}