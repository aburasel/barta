<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{

    /**
     * registration
     */
    public function create()
    {
        if (Session::has("user")) {
            return redirect()->route("dashboard");
        }
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
