<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Tests for the logout endpoint
 */
final class LogoutUserTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_logout_successfully(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'password' => Hash::make('secret-password'),
        ]);

        $user->createToken('Spotify');

        $response = $this->actingAs($user)->postJson(route('logout'));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => __('i18n.logout'),
            ]);

        $user->refresh();
        $this->assertSame(0, $user->tokens()->count(), 'Los tokens deben eliminarse después del logout');
    }


    public function test_logout_requires_authentication(): void
    {
        $response = $this->postJson(route('logout'));

        $response->assertStatus(401);
    }
}
