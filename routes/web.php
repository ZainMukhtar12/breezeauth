<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    if (Auth::check()) {
        // Redirect based on user type
        if (Auth::user()->user_type == 'user') {
            return redirect()->route('home'); // User dashboard route
        } else if (Auth::user()->user_type == 'admin') {
            return redirect()->route('admin.dashboard'); // Admin dashboard route
        }
    } else {
        // Redirect to login if not logged in
        return redirect('/login');
    }
});
/*Route::get('/home', function () {
    return view('home');
})->name('home')->middleware([ 'verified']);*/

Route::get('/dashboard', function () {
    if (Auth::check()) {
        // Redirect based on user type
        if (Auth::user()->user_type == 'user') {
            return redirect()->route('home'); // User dashboard route
        } else if (Auth::user()->user_type == 'admin') {
            return redirect()->route('admin.dashboard'); // Admin dashboard route
        }
    } else {
        // Redirect to login if not logged in
        return redirect('/login');
    }
    //return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route::get('/', function () {
//     return view('welcome');
// });
Route::prefix('user')->middleware('auth', 'verified', IsUser::class)->group(function () {
        Route::get('/home', function () { return view('welcome'); })->name('home');
    });

Route::prefix('admin')->middleware('auth', 'verified', IsAdmin::class)->group(function () {

    // Admin routes go here (e.g., admin panel, user management)
    Route::get('/dashboard', function () { return view('dashboard'); })->name('admin.dashboard');
    });
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
