<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create($username, $token): View
    {
        // collect parameter
        $data['username'] = $username;
        $data['token'] = $token;

        // get user by username for get user email to matches
        $user = User::where('username', $username)->first();

        // check if email and token is valid / matches
        $matches = DB::table('password_reset_tokens')->where('email', $user->email)->where('token', $token)->first();

        // if username and token is valid, return reset password view
        if ($matches) {
            return view('reset-password', $data);
        }

        // If username and token is invalid, return 404
        abort(404);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // validation
        $request->validate([
            'token' => ['required'],
            'username' => ['required'],
            'password' => ['required', 'confirmed', 'without_spaces', 'min:8'],
            'password_confirmation' => ['required'],
        ]);

        // hash password
        $password = bcrypt($request->get('password'));

        // get user by username for update password
        $user = User::where('username', $request->username)->first();

        // update user password
        $user->update([
            'password' => $password
        ]);

        // redirecet to login page with success message
        return redirect('admin/login')->with('success', 'Password reset successfully!');
    }
}
