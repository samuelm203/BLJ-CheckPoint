<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function store(StoreStudentRequest $request): RedirectResponse
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

    public function update(UpdateStudentRequest $request, User $student): RedirectResponse
    {
        if ($student->supervisor_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validated();

        $student->first_name = $validated['first_name'];
        $student->surname = $validated['surname'];
        $student->email = $validated['email'];

        if (! empty($validated['password'])) {
            $student->password = Hash::make($validated['password']);
        }

        $student->save();

        return redirect()->route('supervisor.dashboard')->with('success', 'Lernende/r erfolgreich aktualisiert.');
    }

    public function destroy(User $student): RedirectResponse
    {
        if ($student->supervisor_id !== Auth::id()) {
            abort(403);
        }

        $student->delete();

        return redirect()->route('supervisor.dashboard')->with('success', 'Lernende/r erfolgreich gelöscht.');
    }
}
