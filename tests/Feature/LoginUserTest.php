<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_successfully(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('secret-password'),
        ]);

        $payload = [
            'email' => $user->email,
            'password' => 'secret-password',
        ];

        $response = $this->postJson(route('login'), $payload);

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

        $user->refresh();
        $this->assertEquals(1, $user->tokens()->count());
    }

    public function test_login_fails_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('secret-password'),
        ]);

        $payload = [
            'email' => $user->email,
            'password' => 'wrong-password',
        ];

        $response = $this->postJson(route('login'), $payload);

        $response->assertStatus(500)
            ->assertJsonStructure(['message']);
    }

    public function test_login_fails_with_missing_fields(): void
    {
        $response = $this->postJson(route('login'), []);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }
}
