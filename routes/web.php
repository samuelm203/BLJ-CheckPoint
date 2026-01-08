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
| Authentication
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showAuthForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/register', 'register')->name('register');
});
