<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $alleModule = Module::all();

        $abgeschlosseneModule = $user->completedModules;

        return view('student.dashboard', compact('user', 'alleModule', 'abgeschlosseneModule'));    }
}
