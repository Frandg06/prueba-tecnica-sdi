<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_successfully(): void
    {
        $payload = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson(route('register'), $payload);

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'token',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ])
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', [
            'email' => $payload['email'],
        ]);

        $user = User::where('email', $payload['email'])->first();
        $this->assertTrue(Hash::check('password', $user->password));
    }

    /** @test */
    public function register_fails_with_missing_fields(): void
    {

        $response = $this->postJson(route('register'), []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }

    /** @test */
    public function register_fails_with_duplicate_email(): void
    {
        $existing = User::factory()->create(['email' => 'john@example.com']);

        $payload = [
            'name' => 'John Duplicate',
            'email' => $existing->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson(route('register'), $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }
}
