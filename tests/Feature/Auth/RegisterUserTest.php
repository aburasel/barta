<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{


    public function testRegisterScreenCanBeRendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testUserCanRegisterUsingValidInputs()
    {
        $response = $this->post('/register', [
            'first_name' => 'Abdullah',
            'last_name' => 'Abdur Rahman',
            'email' => 'rahmanss@gmail.com',
            'username' => 'onlytestss',
            'password' => 'password',
        ]);

        
        $response->assertRedirect('/');
        $response->assertSessionDoesntHaveErrors();
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'first_name' => 'Abdullah',
            'last_name' => 'Abdur Rahman',
            'email' => 'rahmanss@gmail.com',
            'username' => 'onlytestss',
        ]);

    }

    public static function provideWrongRegistrationInputs(): array
    {

        return [
            'null' => [null, null, null, null, null],
            'invalid email' => ['Abu Mohammad', 'Rasel', 'test-email', 'user1234', 'password'],
            'invalid username' => ['Abu Mohammad', 'Rasel', 'test-email@gmail.com', 1, 'password'],
        ];
    }

    #[DataProvider('provideWrongRegistrationInputs')]
    public function testUserCanNotRegisterUsingWrongInputs($firstName, $lastName, $email, $userName, $password)
    {

        $response = $this->post('/register', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'username' => $userName,
            'password' => $password,
        ]);

        $this->assertGuest();

    }

    public function testUserCanNotRegisterUsingDuplicateUsernameEmail()
    {
        $user = (User::factory()->create());
        $response = $this->post('/register', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'username' => $user->username,
            'password' => $user->password,
        ]);

        $response->assertSessionHasErrors(['username', 'email']);

    }

}
