<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Alle Module abrufen
        $alleModule = Module::all();

        // Nur die Lernenden laden, die diesem Supervisor zugewiesen sind
        $lernende = $user->students;

        return view('supervisor.dashboard', compact('user', 'alleModule', 'lernende'));
    }
}
