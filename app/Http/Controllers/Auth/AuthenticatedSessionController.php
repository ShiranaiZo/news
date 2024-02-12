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
        // Check if user is authenticated
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
        // redirect to login view
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

        // Authenticate user
        $request->authenticate();

        // set session
        $request->session()->regenerate();

        // redirect to dashboard
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout user
        Auth::guard('web')->logout();

        // remove/reset session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // redirect to login page
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
