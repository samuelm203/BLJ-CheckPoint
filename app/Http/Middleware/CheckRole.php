<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Prüfen, ob der User überhaupt eingeloggt ist
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Prüfen, ob die Rolle des Users mit der benötigten Rolle übereinstimmt
        // Wir nehmen an: '2' ist Supervisor, '1' ist Student
        if (Auth::user()->role !== $role) {
            abort(403, 'Zugriff verweigert. Du hast nicht die benötigten Rechte.');
        }

        return $next($request);
    }
}
