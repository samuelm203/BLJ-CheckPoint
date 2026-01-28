<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        Task::create($request->validated());

        return back()->with('success', 'Aufgabe erfolgreich erstellt.');
    }

    public function toggleComplete(Task $task): RedirectResponse
    {
        $user = Auth::user();

        // Prüfen, ob der User dem Modul der Aufgabe zugewiesen ist
        if (! $user->assignedModules->contains($task->module_id)) {
            abort(403, 'Sie sind diesem Kurs nicht zugewiesen.');
        }

        $pivot = $task->users()->where('user_id', $user->id)->first();

        if ($pivot) {
            $isCompleted = ! $pivot->pivot->is_completed;
            $task->users()->updateExistingPivot($user->id, [
                'is_completed' => $isCompleted,
                'completion_date' => $isCompleted ? now() : null,
            ]);
        } else {
            $task->users()->attach($user->id, [
                'is_completed' => true,
                'completion_date' => now(),
            ]);
        }

        return back()->with('success', 'Aufgabenstatus aktualisiert.');
    }
}
