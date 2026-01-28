<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class SupervisorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Nur die aktiven Module abrufen, die diesem Supervisor gehören
        $aktiveModule = $user->createdModules()
            ->where('is_completed', false)
            ->withCount('assignedStudents')
            ->get();

        // Abgeschlossene Module
        $abgeschlosseneModule = $user->createdModules()
            ->where('is_completed', true)
            ->withCount('assignedStudents')
            ->get();

        // Nur die Lernenden laden, die diesem Supervisor zugewiesen sind
        // Inklusive Fortschritt (Anzahl abgeschlossener Tasks vs. Gesamtanzahl Tasks in zugewiesenen Modulen)
        $lernende = $user->students()->with([
            'tasks' => function ($query) {
                $query->wherePivot('is_completed', true);
            },
            'assignedModules.tasks',
        ])->get();

        return view('supervisor.dashboard', compact('user', 'aktiveModule', 'abgeschlosseneModule', 'lernende'));
    }
}
