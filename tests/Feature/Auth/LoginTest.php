<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get(route('top'));

        $response->assertStatus(200);
    }

    /**
     * 正しい認証情報でログインできることをテスト
     */
    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'pochachillacake@gmail.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post(route('account.authenticate'), [
            'email' => 'pochachillacake@gmail.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('top'));
    }

    /**
     * 間違った認証情報ではログインできないことをテスト
     */
    public function test_user_cannot_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'pochachillacake@gmail.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post(route('account.authenticate'), [
            'email' => 'pochachillacake@gmail.com',
            'password' => 'wrong-password'
        ]);

        $response->assertSessionHas('login_error');
        $this->assertGuest();
    }

    /**
     * 必須フィールドのバリデーションをテスト
     */
    public function test_login_validation_requires_email_and_password(): void
    {
        $response = $this->post(route('account.authenticate'), []);

        $response->assertSessionHasErrors(['email', 'password']);
    }
}
