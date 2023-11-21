<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
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
            dd($validated);
        // $id = DB::table('posts')->insertGetId($validated);
        // if ($id) {
        //     return redirect()->route('dashboard')->with('message', 'success|Post added successfully');
        // } else {
        //     return redirect()->route('dashboard')->withInput()->with('message', 'error|Something went wrong');
        // }

    }
}
