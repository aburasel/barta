<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileSearchRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProfileSearchController extends Controller
{
    
    public function searchProfile(ProfileSearchRequest $request) //
    {
        $user = Auth::user();
        $validated = $request->validated();
        $key=$validated['search'];

        $users = User::where('first_name', 'like', '%' . $key . '%')
        ->select(['id','first_name','last_name','email','username','avatar'])
        ->orWhere('last_name', 'like', '%' . $key . '%')
        ->orWhere('email', 'like', '%' . $key . '%')
        ->orWhere('username', 'like', '%' . $key . '%')
        ->get();

        if ($users->isEmpty()) {
            return view('errors.404', ['user' => $user]);
        }

        return view('profile.searched_profile', ['user' => $user, 'users' => $users]);
    }
}
