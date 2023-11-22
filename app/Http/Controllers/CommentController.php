<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //dd($validated);
        $isInserted = DB::table('comments')->insert($validated);
        if ($isInserted) {
            return redirect()->back()->with('message', 'success|Comment added successfully');
        } else {
            return redirect()->back()->with('message', 'error|Something went wrong');
        }

    }
}
