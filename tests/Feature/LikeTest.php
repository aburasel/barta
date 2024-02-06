<?php

namespace Tests\Feature;

use App\Livewire\LikeAction;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use Tests\MyTestCase;

class LikeTest extends MyTestCase
{

    public function testUserCanLikePost()
    {
        $post = Post::factory()->create();

        $this->actingAs($this->user);

        Livewire::test(LikeAction::class)

            ->set('likedBefore', false)
            ->set('noOfLikes', 5)
            ->set('post', $post)

            ->call('onLikeClick');

        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'post_id' => $post->id,
        ]);
        $this->assertDatabaseCount('likes', 1);

    }

    public function testUserCanUndoLikePost()
    {
        $post = Post::factory()->create();

        $this->actingAs($this->user);

        Livewire::test(LikeAction::class)

            ->set('likedBefore', false)
            ->set('noOfLikes', 5)
            ->set('post', $post)

            ->call('onLikeClick');

        Livewire::test(LikeAction::class)

            ->set('likedBefore', true)
            ->set('noOfLikes', 6)
            ->set('post', $post)

            ->call('onLikeClick');

        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'post_id' => $post->id,
        ]);
        $this->assertDatabaseCount('likes', 0);

    }

}
