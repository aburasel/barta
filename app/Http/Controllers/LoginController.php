<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LoginController extends Controller
{

    public function index(): View
    {
        if (Session::has("user")) {
            return redirect()->route("dashboard");
        }
        return view("auth.login");
    }

    public function postLogin(UserLoginRequest $request)
    {
        $validated = $request->validated();
        $user = DB::table("users")
            ->where("email", $validated["email"])
            ->first();
        if ($user) {
            if (Hash::check($validated["password"], $user->password)) {
                Session::put("user", [
                    'id' => $user->id,
                    "first_name" => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'bio' => $user->bio,
                ]);
                return redirect()->route("dashboard"); //->with("success", "Welcome");
            }
        }
        return redirect()->route("login")->with("error", "Invalid email or password");

    }

    public function logOut()
    {
        Session::flush();
        return redirect()->route("login");
    }
}
