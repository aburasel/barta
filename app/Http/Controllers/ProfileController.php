<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function profile(Request $request) //
    {
        $id = $request->route('id');

        $user = User::where('id', $id)->first();
        if ($user == null) {
            return view('errors.404', ['user' => $user]);
        }

        $user = User::where('id', '=', $id)
            ->withCount(['posts'])
            ->withCount(['comments'])
            ->first();

        $posts = Post::with('user:id,first_name,last_name,username')
            ->where('user_id', '=', $id)
            ->withCount('comments')
            ->get('posts.*');

        return view('profile.profile', ['user' => $user, 'posts' => $posts]);
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

        
        $fields=[
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'username' => $validated['username'],
            'bio' => $validated['bio'],
            'avatar' =>config('constants.DEFAULT_AVATAR_IMAGE_PATH'),
            'updated_at' => now(),
        ];

        if ($request->hasFile('avatar')) {
            if ($request->file('avatar')->isValid()) {
                $imagePath = $request->avatar->store(config('constants.AVATAR_IMAGE_PATH'), 'public');
                $fields['avatar'] = $imagePath;
            }
        }

        $rowsAffected = User::where('id', '=', Auth::user()->id)
            ->update($fields);

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
