<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function store(StoreStudentRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        User::create([
            'first_name' => $validated['first_name'],
            'surname' => $validated['surname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 1, // Student
            'supervisor_id' => Auth::id(),
        ]);

        return redirect()->route('supervisor.dashboard')->with('success', 'Lernende/r erfolgreich erstellt.');
    }
}
