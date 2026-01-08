<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

/*
|--------------------------------------------------------------------------
| Modules
|--------------------------------------------------------------------------
*/
Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');

/*
|--------------------------------------------------------------------------
| Authentication (Supervisor & Student)
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {

    Route::prefix('supervisor')->group(function () {
        Route::get('/login', 'showAuthForm')->name('supervisor.login');

        // Die Verarbeitung bleibt getrennt
        Route::post('/login', 'login')->name('supervisor.login.post');
        Route::post('/register', 'register')->name('supervisor.register.post');
    });

    Route::prefix('student')->group(function () {
        Route::get('/login', 'showAuthForm')->name('student.login');
        Route::post('/login', 'login')->name('student.login.post');
    });

    Route::post('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Protected Areas (Middleware)
|--------------------------------------------------------------------------
*/

// Bereich für Coaches (Rolle 2)
Route::middleware(['auth', 'role:2'])->prefix('supervisor')->group(function () {
    Route::get('/dashboard', function () {
        return view('supervisor.dashboard');
    })->name('supervisor.dashboard');
});

// Bereich für Lernende (Rolle 1)
Route::middleware(['auth', 'role:1'])->prefix('student')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\StudentDashboardController::class, 'index'])
        ->name('student.dashboard');
});
