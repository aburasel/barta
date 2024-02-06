<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\MyTestCase;

class UserProfileTest extends MyTestCase
{

    public function testUnAuthenticatedUserDoNotSeeProfilePage(): void
    {
        $response = $this->get('/profile');
        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function testAuthenticatedUserCanSeeProfilePage(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/profile');
        $response->assertStatus(200);
    }

    public function testAuthenticatedUserCanSeeEditProfilePage(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('profile.edit'));
        $response->assertStatus(200);
    }

    public function testUnAuthenticatedUserCantSeeEditProfilePage(): void
    {
        $response = $this->get(route('profile.edit'));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function testUserCanUpdateProfileUsingValidInputs()
    {
        $response = $this->actingAs($this->user)
            ->patch(route('profile.update'), [
                'first_name' => 'Abdullah',
                'last_name' => 'Abdur Rahman',
                'email' => 'changedemail@gmail.com',
                'username' => 'changedemail',
                'password' => 'password',
                'bio' => 'changedemail',
            ]);

        $response->assertRedirect(route('profile', $this->user->id));
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('users', [
            'email' => 'changedemail@gmail.com',
            'username' => 'changedemail',
            'bio' => 'changedemail',
        ]);

    }

    public function testUserCanUpdateProfileImage()
    {
        Storage::fake('avatars');
        $image = UploadedFile::fake()->image('profile.png');

        $this
            ->actingAs($this->user)
            ->patch(route('profile.update'), [
                'first_name' => 'Abdullah',
                'last_name' => 'Abdur Rahman',
                'avatar' => $image,
                'email' => 'changedemail@gmail.com',
                'username' => 'changedemail',
                'password' => 'password',
                'bio' => 'changedemail',
            ])
            ->assertSessionDoesntHaveErrors()
            ->assertRedirect(route('profile', $this->user->id));

        $this->assertDatabaseHas('users', [
            'avatar' => 'avatars/'.$image->hashName(),
        ]);
    }

}
