<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected function user()
    {
        return (User::factory()->create());
    }
    public function testLoginScreenCanBeRendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testUserCanAuthenticateUsingLoginScreen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUserCanNotAuthenticateUsingInvalidPassword()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function testLoggedUserCantAccessLoginPage(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->get('/login');

        $response->assertRedirect('/')
            ->assertStatus(302);
    }

    public static function provideWrongLoginCredentials(): array
    {
        return [
            'null' => [null, null],
            'invalid email' => ['asdf', null],
            'invalid email password' => ['asdf', 1],
            'empty email password' => ['', ''],
        ];
    }

    #[DataProvider('provideWrongLoginCredentials')]
    public function testUserCanNotAuthenticateWithoutEmailPassword($email, $password)
    {

        $response = $this->post('/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $this->assertGuest();

    }
}
