<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostDeleteRequest;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostFeedRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('home.index', ['user' => $user]);
    }

    public function store(PostFeedRequest $request)
    {

        $validated = $request->validated();
        //dd($validated);

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $imagePath = $request->image->store(config('constants.POST_IMAGE_PATH'), 'public');
                $validated['image'] = $imagePath;
            }
        }

        $validatedAfterMerge = array_merge(
            $validated,
            [
                'user_id' => Auth::user()->id,
                'created_at' => now(),
            ]
        );

        $post = Post::create($validatedAfterMerge);

        if ($post) {
            return redirect()->route('dashboard')->with('message', 'success|Post added successfully');
        } else {
            return redirect()->route('dashboard')->withInput()->with('message', 'error|Something went wrong');
        }

    }

    public function postByTags(Request $request)
    {
        $key = $request->route('key');
        $user = Auth::user();
        $posts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.username', 'posts.*')
            ->where('posts.description', 'like', '%#' . $key . '%')
            ->orderBy('posts.created_at', 'desc')->get();

        //DB::table("posts")->increment('posts.view_count', 1, []);

        return view('home.index', ['user' => $user, 'posts' => $posts]);
    }

    public function viewPostByUUID(Request $request)
    {
        $key = $request->route('key');
        $user = Auth::user();

        $post = Post::with(
            [
                'user:id,first_name,last_name,username,avatar',
                'comments' => function ($query) {
                    $query->with('user:id,first_name,last_name,username');
                },
            ])
            ->withCount('comments')
            ->where('posts.id', '=', $key)
            ->first();

        if ($post) {
            $post->increment('view_count');

            return view('home.single', ['user' => $user, 'post' => $post]);
        } else {
            return view('errors.404', ['user' => $user]);
        }

    }

    public function editPostByUUID(Request $request)
    {
        $this->authorize('edit', Post::class);
        
        $key = $request->route('key');
        $user = Auth::user();

        $post = Post::find($key)->with(
            [
                'user:id,first_name,last_name,username',
            ])->first();

        if ($post) {
            return view('home.single_edit', ['user' => $user, 'post' => $post]);
        } else {
            return view('errors.404', ['user' => $user]);
        }

    }

    public function storePostByUUID(PostEditRequest $request)
    {

        $id = $request->route('key');
        $this->authorize('update', Post::find($id));
        $validated = $request->validated();

        $validated = array_merge(
            $validated,
            [
                'updated_at' => now(),
            ]
        );
        Post::where([
            'id' => $id,
            'user_id' => Auth::user()->id,
        ])->update($validated);

        if ($id) {
            return redirect()->route('dashboard')->with('message', 'success|Post updated successfully');
        } else {
            return back()->withInput();
        }

    }

    public function delete(Request $request)
    {
        $key = $request->route('key');
        $this->authorize('delete', Post::find($key));
        $rowsAffected = Post::where('id', $key)->delete();
        if ($rowsAffected) {
            return redirect()->route('dashboard')->with('message', 'success|Post deleted successfully');
        } else {
            return back()->withInput();
        }

    }
}
