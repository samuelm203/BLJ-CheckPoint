<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showAuthForm(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->role == '2') {
                return redirect()->route('supervisor.dashboard');
            }

            return redirect()->route('student.dashboard');
        }

        // Wenn die URL mit supervisor/ beginnt
        if ($request->is('supervisor/*')) {
            return view('auth.login_supervisor');
        }

        // Standardmässig für Students
        return view('auth.login_student');
    }

    public function showRegisterForm()
    {
        return view('auth.register_supervisor');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $expectedRole = $request->is('supervisor/*') ? '2' : '1';

        if (Auth::attempt(array_merge($credentials, ['role' => $expectedRole]))) {
            $user = Auth::user();

            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            $request->session()->regenerate();

            if ($user->role == '2') {
                return redirect()->intended('/supervisor/dashboard');
            }

            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors(['email' => 'Zugangsdaten falsch oder falsche Login-Seite.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request)
    {

        if (! $request->is('supervisor/*')) {
            abort(403, 'Registrierung für Lernende nicht erlaubt.');
        }

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => '2', // Supervisor
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        Auth::login($user);

        return redirect('/supervisor/dashboard');
    }
}
