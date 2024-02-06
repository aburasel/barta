<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\MyTestCase;

class CommentTest extends MyTestCase
{

    public function testUserCanComment()
    {
        $post = Post::factory()->create();
        $response = $this->actingAs($this->user)
            ->post(route('comment'), [
                'comment' => 'a new comment',
                'post_id' => $post->id,
            ]
            );

        $response->assertRedirect(session()->previousUrl());
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('comments', [
            'comment' => 'a new comment',
            'user_id' => $this->user->id,
            'post_id' => $post->id,
        ]);

    }

    public function testUserCantCommentWithInvalidInputs()
    {
        $post = Post::factory()->create();
        $response = $this->actingAs($this->user)
            ->post(route('comment'), [
                'comment' => null,
                'post_id' => $post->id,
            ]
            );

        $response->assertRedirect(session()->previousUrl());
        $response->assertSessionHasErrors(['comment']);

    }

}
