<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{

    /**
     * registration
     */
    public function create()
    {
        return view("auth.register");
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
            $credentials = ["email" => $validated["email"], "password" => $validated["password"]];

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route("dashboard");
            }
            return redirect()->route("user.login");
        } else {
            return redirect()->route("user.register")->with("errors", "Error happend");
        }

    }
}
