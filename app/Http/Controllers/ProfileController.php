<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function profile(Request $request): View
    {
        $id = $request->route('id');

        $user = DB::table('users')->where('id', $id)->first(); //Auth::user();
        if ($user == null) {
            return view('errors.404', ['user' => $user]);
        }

        $posts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.username', 'posts.*')
            ->where('posts.user_id', '=', $id)
            ->orderBy('posts.created_at', 'desc')->get();
        $noOfComment = DB::table('comments')
            ->where('comments.user_id', '=', $id)->count();

        $count = ['noOfPost' => count($posts), 'noOfComment' => $noOfComment];

        $perPostCommentCount = DB::table('comments')
            ->join('posts', 'posts.uuid', '=', 'comments.post_uuid')
            ->select('posts.uuid', DB::raw('COUNT(*) as numberOfComment'))
            ->groupBy('posts.uuid')
            ->get();

        return view('profile.profile', ['user' => $user, 'posts' => $posts, 'counts' => $count, 'perPostCommentCount' => $perPostCommentCount]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        //$request->user()->fill($validated);

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }
        $rowsAffected = DB::table('users')
            ->where('id', '=', Auth::user()->id)
            ->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'username' => $validated['username'],
                'bio' => $validated['bio'],
                'updated_at' => now(),
            ]);

        //$request->user()->save();
        if ($rowsAffected > 0) {
            return redirect()->route('profile', Auth::user()->id)->with('status', 'profile-updated');
        } else {
            return redirect()->route('profile.edit')->with('error', 'Error happened');
        }
        //return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
