<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function profile(): View
    {
        $user = DB::table("users")->where("id", Session::get("user.id"))->first();
        return view('profile.profile',(array)$user);
    }
    public function create()
    {
        if (!Session::has("user")) {
            return redirect()->route("auth.login");
        }
        $user = DB::table("users")->select('id', 'first_name', 'last_name', 'bio', 'email', 'password')->where('id', '=', session('user.id'))->first();
        //dd((array)$user);
        return view("profile.edit_profile", (array) $user);
    }

    public function store(ProfileRequest $request)
    {
        $validated = $request->validated();

        $rowsAffected = DB::table("users")
            ->where("id", "=", session("user.id"))
            ->update([
                "first_name" => $validated["first_name"],
                "last_name" => $validated["last_name"],
                "email" => $validated["email"],
                "password" => bcrypt($validated["password"]),
                "bio" => $validated["bio"],
                "updated_at" => now(),
            ]);

        if ($rowsAffected >= 0) {
            return redirect()->route("profile")->with("success", "Profile updated successfully");
        } else {
            return redirect()->route("profile.edit")->with("error", "Error happend");
        }

    }

}
