<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_create_worker(): void
    {
        // Create an owner user
        $owner = User::factory()->create([
            'role' => 'Owner',
            'owner_id' => null,
        ]);

        // Authenticate as the owner and bypass middleware
        $this->actingAs($owner);
        
        // Make the request directly
        $response = $this->postJson('/api/users', [
            'name' => 'Test Worker',
            'email' => 'worker@example.com',
            'password' => 'password123',
        ]);

        // Assert the response status and structure
        $response->assertStatus(201)
            ->assertJsonStructure([
                'worker' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'owner_id',
                    'created_at',
                    'updated_at',
                ],
            ]);

        // Assert the database has the worker with correct attributes
        $this->assertDatabaseHas('users', [
            'name' => 'Test Worker',
            'email' => 'worker@example.com',
            'role' => 'Worker',
            'owner_id' => $owner->id,
        ]);
    }

    public function test_owner_can_create_worker_with_generated_password(): void
    {
        // Create an owner user
        $owner = User::factory()->create([
            'role' => 'Owner',
            'owner_id' => null,
        ]);

        // Authenticate as the owner and bypass middleware
        $this->actingAs($owner);
        
        // Make the request directly
        $response = $this->postJson('/api/users', [
            'name' => 'Test Worker',
            'email' => 'worker@example.com',
        ]);

        // Assert the response status and structure
        $response->assertStatus(201)
            ->assertJsonStructure([
                'worker' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'owner_id',
                    'created_at',
                    'updated_at',
                ],
                'generated_password',
                'message',
            ]);

        // Assert the database has the worker with correct attributes
        $this->assertDatabaseHas('users', [
            'name' => 'Test Worker',
            'email' => 'worker@example.com',
            'role' => 'Worker',
            'owner_id' => $owner->id,
        ]);
    }

    public function test_worker_cannot_create_another_user(): void
    {
        // Create an owner user
        $owner = User::factory()->create([
            'role' => 'Owner',
            'owner_id' => null,
        ]);

        // Create a worker user
        $worker = User::factory()->create([
            'role' => 'Worker',
            'owner_id' => $owner->id,
        ]);

        // Authenticate as the worker and bypass middleware
        $this->actingAs($worker);
        
        // Make the request directly
        $response = $this->postJson('/api/users', [
            'name' => 'Another Worker',
            'email' => 'another@example.com',
            'password' => 'password123',
        ]);

        // Assert the response is forbidden
        $response->assertStatus(403);

        // Assert the database does not have the new user
        $this->assertDatabaseMissing('users', [
            'email' => 'another@example.com',
        ]);
    }

    public function test_owner_cannot_create_user_with_duplicate_email(): void
    {
        // Create an owner user
        $owner = User::factory()->create([
            'role' => 'Owner',
            'owner_id' => null,
        ]);

        // Create a worker user
        User::factory()->create([
            'email' => 'existing@example.com',
            'role' => 'Worker',
            'owner_id' => $owner->id,
        ]);

        // Authenticate as the owner and bypass middleware
        $this->actingAs($owner);
        
        // Make the request directly
        $response = $this->postJson('/api/users', [
            'name' => 'Duplicate Email',
            'email' => 'existing@example.com',
            'password' => 'password123',
        ]);

        // Assert the response has validation errors
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_owner_can_list_their_workers(): void
    {
        // Create an owner user
        $owner = User::factory()->create([
            'role' => 'Owner',
            'owner_id' => null,
        ]);

        // Create some workers for this owner
        $workers = User::factory()->count(3)->create([
            'role' => 'Worker',
            'owner_id' => $owner->id,
        ]);

        // Authenticate as the owner and bypass middleware
        $this->actingAs($owner);
        
        // Make the request directly
        $response = $this->getJson('/api/users');

        // Assert the response status and structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'owner' => [
                    'id',
                    'name',
                    'email',
                    'role',
                ],
                'workers' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'role',
                        'owner_id',
                    ],
                ],
            ]);

        // Assert the response contains the correct number of workers
        $response->assertJsonCount(3, 'workers');
    }

    public function test_worker_can_only_see_themselves(): void
    {
        // Create an owner user
        $owner = User::factory()->create([
            'role' => 'Owner',
            'owner_id' => null,
        ]);

        // Create a worker user
        $worker = User::factory()->create([
            'role' => 'Worker',
            'owner_id' => $owner->id,
        ]);

        // Create some other workers for this owner
        User::factory()->count(3)->create([
            'role' => 'Worker',
            'owner_id' => $owner->id,
        ]);

        // Authenticate as the worker and bypass middleware
        $this->actingAs($worker);
        
        // Make the request directly
        $response = $this->getJson('/api/users');

        // Assert the response status and structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'owner_id',
                ],
            ]);

        // Assert the response does not contain a 'workers' key
        $response->assertJsonMissing(['workers']);
    }
} 