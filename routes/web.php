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
Route::view('/about', 'start.about')->name('about');
Route::view('/contact', 'start.contact')->name('contact');
Route::view('/privacy', 'home')->name('privacy'); // Temporary fallback if views missing
Route::view('/terms', 'home')->name('terms');     // Temporary fallback if views missing

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
        Route::get('/login-redirect', function () {
            return redirect()->route('student.login');
        })->name('login'); // Added named 'login' route
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
    Route::get('/dashboard', [App\Http\Controllers\SupervisorDashboardController::class, 'index'])
        ->name('supervisor.dashboard');
    Route::post('/students', [App\Http\Controllers\StudentController::class, 'store'])
        ->name('supervisor.students.store');
    Route::put('/students/{student}', [App\Http\Controllers\StudentController::class, 'update'])
        ->name('supervisor.students.update');
    Route::delete('/students/{student}', [App\Http\Controllers\StudentController::class, 'destroy'])
        ->name('supervisor.students.destroy');
    Route::post('/modules', [ModuleController::class, 'store'])
        ->name('supervisor.modules.store');
    Route::get('/modules/{module}', [ModuleController::class, 'show'])
        ->name('supervisor.modules.show');
    Route::post('/modules/{module}/assign-students', [ModuleController::class, 'assignStudents'])
        ->name('supervisor.modules.assign-students');
    Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store'])
        ->name('supervisor.tasks.store');
});

// Bereich für Lernende (Rolle 1)
Route::middleware(['auth', 'role:1'])->prefix('student')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\StudentDashboardController::class, 'index'])
        ->name('student.dashboard');
});
