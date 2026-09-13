<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'access_token',
                'token_type',
                'user' => ['id', 'name', 'email', 'phone'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
            'phone' => '08123456789',
        ]);
    }

    public function test_user_can_not_register_with_same_email(): void
    {
        User::factory()->create([
            'email' => 'budi@example.com',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08129999999',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'email' => ['The email has already been taken.'],
            ]);
    }

    public function test_user_can_not_register_with_same_phone(): void
    {
        User::factory()->create([
            'phone' => '08123456789',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Budi Santoso',
            'email' => 'budi_lain@example.com',
            'phone' => '08123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'phone' => ['The phone has already been taken.'],
            ]);
    }
}
