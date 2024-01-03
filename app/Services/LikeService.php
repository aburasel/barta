<?php

namespace App\Services;

use App\Models\Like;
use Exception;

class LikeService
{

    public function updateLike(array $data): int
    {
        try {
            $like = Like::where(['user_id' => $data['user_id'], 'post_id' => $data['post_id']])->first();
            if ($like) {
                $this->destroy($like->id);
                return -1;
            } else {
                $like = [
                    'user_id' => $data['user_id'],
                    'post_id' => $data['post_id'],
                ];
                Like::create($like);
                return 1;
            }
        } catch (Exception $e) {
            return 0;
        }

    }

    private function destroy($id)
    {
        Like::destroy($id);        
    }
}
