<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRegistrationRequest $request): RedirectResponse
    {

        $validated = $request->validated();
        $validatedAfterMerge = array_merge(
            $validated,
            [
                'avatar' => config('constants.DEFAULT_AVATAR_IMAGE_PATH'),
            ]
        );

        $registeredUser = User::create($validatedAfterMerge);

        event(new Registered($registeredUser));

        Auth::login($registeredUser);

        return redirect(RouteServiceProvider::HOME);
    }
}
