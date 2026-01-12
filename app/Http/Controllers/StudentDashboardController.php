<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all modules assigned to the student
        $assignedModules = $user->assignedModules;

        // Separate into open and completed
        $alleModule = $assignedModules->where('pivot.has_completed_user', false);
        $abgeschlosseneModule = $assignedModules->where('pivot.has_completed_user', true);

        return view('student.student_dashboard', compact('user', 'alleModule', 'abgeschlosseneModule'));
    }
}
