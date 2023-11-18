<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostDeleteRequest;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostFeedRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PostController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $posts = DB::table("posts")
            ->join("users", "users.id", "=", "posts.user_id")
            ->select("users.id", "users.first_name", "users.last_name", "posts.*")
            ->orderBy("posts.created_at", "desc")->get();

        DB::table("posts")->increment('posts.view_count', 1, []);

        return view("home.index", ['user' => $user, 'posts' => $posts]);
    }

    public function store(PostFeedRequest $request)
    {
        $validated = $request->validated();
        $validated = array_merge(
            $validated,
            [
                "uuid" => (string) Uuid::uuid4(),
                "user_id" => Auth::user()->id,
                "created_at" => now(),
            ]);
        $id = DB::table("posts")->insertGetId($validated);
        if ($id) {
            return redirect()->route("dashboard")->with("message", "success|Post added successfully");
        } else {
            return redirect()->route("dashboard")->withInput()->with("message", "error|Something went wrong");
        }

    }
    public function postByTags(Request $request)
    {
        $key = $request->route('key');
        $user = Auth::user();
        $posts = DB::table("posts")
            ->join("users", "users.id", "=", "posts.user_id")
            ->select("users.id", "users.first_name", "users.last_name", "posts.*")
            ->where("posts.description", 'like', '%#' . $key . '%')
            ->orderBy("posts.created_at", "desc")->get();

        //DB::table("posts")->increment('posts.view_count', 1, []);

        return view("home.index", ['user' => $user, 'posts' => $posts]);
    }

    public function viewPostByUUID(Request $request)
    {
        $key = $request->route('key');
        $user = Auth::user();

        $post = DB::table("posts")
            ->join("users", "users.id", "=", "posts.user_id")
            ->select("users.id", "users.first_name", "users.last_name", "posts.*")
            ->where("posts.uuid", '=', $key)
            ->first();
        if ($post) {
            DB::table("posts")->where("posts.uuid", '=', $key)->increment('posts.view_count', 1, []);
            return view("home.single", ['user' => $user, 'post' => $post]);
        } else {
            return view("errors.404", ['user' => $user]);
        }

    }
    public function editPostByUUID(Request $request)
    {
        $key = $request->route('key');
        $user = Auth::user();
        $post = DB::table("posts")
            ->join("users", "users.id", "=", "posts.user_id")
            ->select("users.id", "users.first_name", "users.last_name", "posts.*")
            ->where("posts.uuid", '=', $key)
            ->first();
        if ($post) {
            return view("home.single_edit", ['user' => $user, 'post' => $post]);
        } else {
            return view("errors.404", ['user' => $user]);
        }

    }

    public function storePostByUUID(PostEditRequest $request)
    {

        $uuid = $request->route('key');
        $validated = $request->validated();

        $validated = array_merge(
            $validated,
            [
                "updated_at" => now(),
            ]
        );
        $id = DB::table("posts")->where([
            "uuid" => $uuid,
            "user_id" => Auth::user()->id,
        ])->update($validated);

        if ($id) {
            return redirect()->route("dashboard")->with("message", "success|Post updated successfully");
        } else {
            return back()->withInput();
        }

    }

    public function delete(PostDeleteRequest $request)
    {

        $key = $request->route('key');
        $rowsAffected = DB::table("posts")->where("uuid", $key)->delete();

        if ($rowsAffected) {
            return redirect()->route("dashboard")->with("message", "success|Post deleted successfully");
        } else {
            return back()->withInput();
        }

    }

}
