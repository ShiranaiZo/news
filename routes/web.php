<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('public/index');
});

// Route::get('/dashboard', function () {
//     return view('index');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/', [ArticleController::class, 'index']);
Route::get('/read/{slug}', [ArticleController::class, 'show']);
Route::get('/get-public-articles/{limit}/{search?}', [ArticleController::class, 'getPublicArticles']);

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', function () {
        return view('index');
    })->name('dashboard');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::group(['middleware' => ['roles:1']], function() {
        Route::resource('admin/users', UserController::class);
        Route::post('/admin/switch-user', [AuthenticatedSessionController::class, 'switchUser']);
    });

    Route::resource('/admin/articles', ArticleController::class);

});

require __DIR__.'/auth.php';
