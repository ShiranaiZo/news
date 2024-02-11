<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Page
    Route::get('/', function () {
        return view('public/index');
    });
    Route::get('/read/{slug}', [ArticleController::class, 'show']);
    Route::get('/get-public-articles/{limit}/{search?}', [ArticleController::class, 'getPublicArticles']);
// End Public Page

// Backend Page
    // Login
    Route::get('/admin', [AuthenticatedSessionController::class, 'checkLogin']);
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password
    Route::get('/admin/forgot-password', [PasswordResetLinkController::class, 'create']) ->name('password.request');
    Route::post('/admin/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/admin/reset-password/{username}/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/admin/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    // User Already Login
    Route::middleware('auth')->group(function () {
        // Dashboard
        Route::get('/admin/dashboard', function () {
            return view('index');
        })->name('dashboard');

        // Admin Role
        Route::group(['middleware' => ['roles:1']], function() {
            // CRUD Users
            Route::resource('admin/users', UserController::class);

            // Switch User
            Route::post('/admin/switch-user', [AuthenticatedSessionController::class, 'switchUser']);
        });

        // CRUD Articles
        Route::resource('/admin/articles', ArticleController::class);

        // Logout
        Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
// End Backend Page
