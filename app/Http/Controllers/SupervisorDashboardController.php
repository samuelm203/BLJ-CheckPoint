<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Nur die Module abrufen, die diesem Supervisor gehören
        $alleModule = $user->createdModules;

        // Nur die Lernenden laden, die diesem Supervisor zugewiesen sind
        $lernende = $user->students;

        return view('supervisor.dashboard', compact('user', 'alleModule', 'lernende'));
    }
}
