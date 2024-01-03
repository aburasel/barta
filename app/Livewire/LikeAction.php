<?php

namespace App\Livewire;

use App\Events\PostLiked;
use App\Models\Like;
use App\Models\Post;
use App\Services\LikeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LikeAction extends Component
{
    use AuthorizesRequests;
    public Post $post;
    public $noOfLikes;
    public $likedBefore;

    public function render()
    {
        return view('livewire.like-action');
    }

    public function onLikeClick(LikeService $likeService)
    {

        $this->authorize('create', Like::class);
        $like = [
            'user_id' => auth()->user()->id,
            'post_id' => $this->post['id'],
        ];
        $likeChange = $likeService->updateLike($like);
        if ($likeChange != 0) {
            $this->likedBefore = !($this->likedBefore);
        }
        $this->noOfLikes += $likeChange;
        if ($likeChange == 1) {
            event(new PostLiked($this->post));
        }
    }
}
