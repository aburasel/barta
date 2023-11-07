<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class AppController extends Controller
{

    public function index()
    {
        if (!Session::has("user")) {
            return redirect()->route("login");
        }
        //session()->flush();
        return view("home.index");
    }
}
