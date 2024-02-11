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
        $data['username'] = $username;
        $data['token'] = $token;
        $user = User::where('username', $username)->first();
        $matches = DB::table('password_reset_tokens')->where('email', $user->email)->where('token', $token)->first();
        if ($matches) {
            return view('reset-password', $data);
        }
        abort(404);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'username' => ['required'],
            'password' => ['required', 'confirmed', 'without_spaces', 'min:8'],
            'password_confirmation' => ['required'],
        ]);

        $password = bcrypt($request->get('password'));

        $user = User::where('username', $request->username)->first();

        $user->update([
            'password' => $password
        ]);

        return redirect('admin/login')->with('success', 'Password reset successfully!');
    }
}
