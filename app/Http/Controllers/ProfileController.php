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
        return view('main.profile');
    }
    public function editProfile()
    {
        if (!Session::has("user")) {
            return redirect()->route("auth.login");
        }
        $user= DB::table("users")->select('id','first_name','last_name','bio','email','password')->where('id','=',session('user.id'))->first();
        //dd((array)$user);
        return view("main.edit_profile",(array)$user);
    }
    
    public function postProfile(ProfileRequest $request)
    {
        $validated = $request->validated();

        $id = DB::table("users")->insertGetId([
            "first_name" => $validated["first_name"],
            "last_name" => $validated["last_name"],
            "email" => $validated["email"],
            "password" => bcrypt($validated["password"]),
            "created_at" => now(),
        ]);

        if ($id) {
            Session::put("user", [
                'id' => $id,
                "first_name" => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
            ]);
            return redirect()->route("dashboard")->with("errors", "Error happend");
        } else {
            return redirect()->route("user.register")->with("success", "");
        }

    }

}
