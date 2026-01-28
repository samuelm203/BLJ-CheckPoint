<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all modules assigned to the student
        $assignedModules = $user->assignedModules()->get();

        // Separate into open and completed (based on module completion status)
        $alleModule = $assignedModules->where('is_completed', false);
        $abgeschlosseneModule = $assignedModules->where('is_completed', true);

        return view('student.student_dashboard', compact('user', 'alleModule', 'abgeschlosseneModule'));
    }

    public function showModule(\App\Models\Module $module)
    {
        $user = Auth::user();

        // Check if student is assigned to this module
        if (! $user->assignedModules->contains($module->module_id)) {
            abort(403);
        }

        $module->load(['tasks.users' => function ($query) use ($user) {
            $query->where('users.id', $user->id);
        }]);

        return view('student.modules.show', compact('user', 'module'));
    }
}
