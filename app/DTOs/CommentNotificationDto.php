<?php

namespace App\DTOs;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentNotificationDto
{
    public function __construct(
        public readonly User $postOwner,
        public readonly User $commenter,
        public readonly Comment $comment,
        public readonly Post $post,
    ) {

    }
}
