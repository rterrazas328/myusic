<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use DB;
use Mail;

class ForgotUsernameLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.username', [ 'page_name' => 'username']);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:100'],
        ]);

        $userEmail = $request->only('email');
        $results = DB::select('SELECT user FROM users WHERE email = ?', [$userEmail['email']]);


		if($results){
            $eMessage = "Your username is ".$results[0]->user;
			Mail::raw($eMessage, function($message) use ($userEmail){

				$message->to($userEmail['email'])->subject('User Name Retrieval!');
			});

            return redirect()->route('login')->with('status', 'Username sent!');
			//return view('auth.login', [ 'page_name' => 'login']);
		}
		else{

            return redirect()->back()->withErrors(['email' => 'User not found']);
			//return view('auth.username', [ 'page_name' => 'username']);
		}

        /*
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );



        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);*/
    }
}
