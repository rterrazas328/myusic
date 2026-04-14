<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', ['page_name' => 'register']);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'honeypot' => ['required', 'in:IS-421-RRZ'],
            'signup-v1-firstname' => ['required', 'string', 'max:32'],
            'signup-v1-lastname' => ['required', 'string', 'max:32'],
            'signup-v1-username' => ['required', 'string', 'max:100', 'unique:users,user'],
            'signup-v1-email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:users,email'],
            'signup-v1-password' => ['required', 'confirmed', Rules\Password::defaults()],
            //'name' => ['required', 'string', 'max:255'],
            //'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            //'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->input('signup-v1-firstname'),
            'last' => $request->input('signup-v1-lastname'),
            'user' => $request->input('signup-v1-username'),
            'email' => $request->input('signup-v1-email'),
            'password' => Hash::make($request->input('signup-v1-password')),
            'userlevel' => false,
            //'name' => $request->name,
            //'email' => $request->email,
            //'password' => Hash::make($request->password),
        ]);

        /*$userProfile = new UserProfile;
		$userProfile->id = $user->id;
		$userProfile->save();*/

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
