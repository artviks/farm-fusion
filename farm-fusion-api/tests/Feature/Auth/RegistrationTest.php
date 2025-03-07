<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_register_successfully(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test Owner',
            'email' => 'owner@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'created_at',
                    'updated_at',
                ],
                'token',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test Owner',
            'email' => 'owner@example.com',
            'role' => 'Owner',
            'owner_id' => null,
        ]);

        $this->assertNotNull($response->json('token'));
    }

    public function test_registration_fails_with_duplicate_email(): void
    {
        // Create a user with the same email
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Another User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
} 