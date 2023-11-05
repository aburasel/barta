<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view("auth.register");
    }

    public function store(UserRegistrationRequest $request)
    {
        $validated= $request->validated();
        dd($validated);
        //return view('auth.register');
        //dd($request->all());
        //return view("auth.register");//->with('about_data_array', $about_data_array)->with('urls', $this->urls);
    }
}
