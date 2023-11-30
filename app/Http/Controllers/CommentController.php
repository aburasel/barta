<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
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

        $isInserted = Comment::create($validated);
        if ($isInserted) {
            return redirect()->back()->with('message', 'success|Comment added successfully');
        } else {
            return redirect()->back()->with('message', 'error|Something went wrong');
        }

    }
}
