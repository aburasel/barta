<?php

namespace App\Http\Controllers;

use App\DTOs\CommentNotificationDto;
use App\Events\PostCommented;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $validated = $request->validated();
        $validated = array_merge(
            $validated,
            [
                'user_id' => Auth::user()->id,
                'created_at' => now(),
            ]);

        $comment = Comment::create($validated);

        if ($comment) {
            
            $post = Post::where(['id' => $validated['post_id']])->first();
            if($comment->user_id !=$post->user_id){
                $postOwner = User::find($post->user_id);
                $postOwner = User::find($post->user_id);
                $commentNotificationDto = new CommentNotificationDto($postOwner,auth()->user(), $comment, $post);
                //dd($commentNotificationDto);
                event(new PostCommented($commentNotificationDto));
            }           

            return redirect()->back()->with('message', 'success|Comment added successfully');
        } else {
            return redirect()->back()->with('message', 'error|Something went wrong');
        }

    }
}
