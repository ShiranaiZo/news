<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Session;

class AuthenticatedSessionController extends Controller
{
    public function checkLogin(){
        if (Auth::check()) {
            return redirect("admin/dashboard");
        }else{
            return redirect('admin/login');
        }
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validation
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function switchUser(Request $request) {
        // find user by id
        $user = User::find($request->user_id);

        // if user found, put user_id to session
        if ($user) {
            Session::put('user_id', $request->user_id);
        }

        // get previous url
        $url = url()->previous();

        // Explode url for array
        $get_url = explode('/', $url);

        // redirect to articles index page
        return redirect('/'.$get_url[3].'/'. $get_url[4]);
    }
}
