<?php

namespace App\Livewire;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostListItems extends Component
{
    public $postIds;

    public function render()
    {
        $user = Auth::user();

        $posts = Post::with('user:id,first_name,last_name,username,avatar')
            ->whereIn('id', $this->postIds)
            ->orderByDesc('created_at')
            ->withCount('comments')
            ->withCount('likes') //->toRawSql();
            ->get('posts.*');
            
        $postLikes = Like::where('user_id', auth()->user()->id)
            ->get();
        //dd($postLikes);


        return view('livewire.post-list-items', [
            'posts' => $posts,
            'user' => $user,
            'postLikes' => $postLikes,
        ]);
    }
}
