<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        if (Session::has("user")) {
            return redirect()->route("dashboard");
        }
        return view("auth.login");
    }

    public function create()
    {
        if (Session::has("user")) {
            return redirect()->route("dashboard");
        }
        return view("auth.register");
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

    public function store(UserRegistrationRequest $request)
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
