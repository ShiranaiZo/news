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
        return view('forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert([
                'email' => $request->email,
            ],[
                'token' => $token,
                'created_at' => now(),
            ]);

            Mail::send('email.forgot-password', ['token' => $token, 'user' => $user], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return back()->with('success', 'We have e-mailed your password reset link!');
        }else{
            return back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
        }
    }
}
