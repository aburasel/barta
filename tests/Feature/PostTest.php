<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\MyTestCase;

class PostTest extends MyTestCase
{
    
    public function testLoggedUserCanSeeHomePage(): void
    {
        $response = $this->actingAs($this->user)->get('/');
        $response->assertOk();
    }

    public function testUnAuthenticatedUserCantSeeSinglePost(): void
    {
        $response = $this->get(route('feed.single', $this->user->id));
        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    public function testUserCanCreatePosts()
    {
        Storage::fake('images');
        $image = UploadedFile::fake()->image('random.jpg');
        $response = $this->actingAs($this->user)
            ->post(route('feed.post'), [
                'description' => 'abcdefg...',
                'image' => $image,
            ]
            );

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('posts', [
            'description' => 'abcdefg...',
            'user_id' => $this->user->id,
            'image' => 'images/' . $image->hashName(),
        ]);

    }

    public function testUserCantPostWithInvalidInputs()
    {
        Storage::fake('images');
        $image = UploadedFile::fake()->image('random.jpg');
        $response = $this->actingAs($this->user)
            ->post(route('feed.post'), [
                'description' => null,
            ]
            );

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHasErrors(['description']);

    }

    public function testUserCanUpdatePost()
    {
        $post = Post::factory()->create(['description' => 'new post', 'user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->post(route('post.edit.store', $post->id), [
                'description' => 'updated post',
            ]
            );

        $response->assertStatus(302)->assertRedirect(route('dashboard'));
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('posts', [
            'description' => 'updated post',
            'user_id' => $this->user->id,
        ]);

    }

    public function testUserCantUpdateOthersPost()
    {
        $user= User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$user->id]);

        $response = $this->actingAs($this->user)

            ->post(route('post.edit.store', $post->id), [
                'description' => 'updated post',
            ]
            );
        $response->assertForbidden();

    }

    public function testUserCanDeleteOwnPost()
    {
        $post = Post::factory()->create(['description' => 'new post', 'user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->get(route('post.delete', $post->id));

        $this->assertDatabaseMissing('posts',['id'=>$post->id,'user_id'=>$this->user->id]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('message');

    }

    public function testUserCantDeleteOtherPost()
    {
        $user= User::factory()->create();
        $post = Post::factory()->create(['user_id'=>$user->id]);

        $response = $this->actingAs($this->user)
            ->get(route('post.delete', $post->id));

            $this->withoutExceptionHandling();
        $response->assertForbidden();

    }

}
