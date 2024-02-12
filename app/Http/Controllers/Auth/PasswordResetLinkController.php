<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Mail;
use Str;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        // redirect to forgot password view
        return view('forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // valiidation
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // get user by email for check if email registered
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // generate token
            $token = Str::random(64);

            // insert if not exists or update if exists by email
            DB::table('password_reset_tokens')->updateOrInsert([
                'email' => $request->email,
            ],[
                'token' => $token,
                'created_at' => now(),
            ]);

            // send email
            Mail::send('email.forgot-password', ['token' => $token, 'user' => $user], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            // redirect to previous url with success message
            return back()->with('success', 'We have e-mailed your password reset link!');
        }else{
            // redirect to previous url with errors message
            return back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
        }
    }
}
