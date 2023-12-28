<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostControllerTest extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // $posts = Post::with('user:id,first_name,last_name,username,avatar')
        //     ->orderByDesc('created_at')
        //     ->withCount('comments')->get('posts.*');
        //return view('home.index', ['user' => $user, 'posts' => $posts]);
        return view('home.index', ['user' => $user]);
    }
}
