<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModuleRequest;
use App\Models\Module;
use Illuminate\Http\RedirectResponse;

class ModuleController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->role == 2) {
            // Coach sieht seine eigenen Module
            $modules = $user->createdModules()->with('tasks')->get();
        } elseif ($user && $user->role == 1) {
            // Student sieht die Module, denen er zugewiesen ist
            $modules = $user->assignedModules()->with('tasks')->get();
        } else {
            // Nicht eingeloggt oder andere Rolle - leere Liste oder alle öffentlichen
            $modules = Module::with('tasks')->get();
        }

        return view('modules.index', compact('modules'));
    }

    public function store(StoreModuleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $module = Module::create([
            'module_name' => $validated['module_name'],
            'description' => $validated['description'],
            'user_id' => auth()->id(),
        ]);

        if (! empty($validated['tasks'])) {
            foreach ($validated['tasks'] as $taskTitle) {
                if (! empty($taskTitle)) {
                    $module->tasks()->create(['title' => $taskTitle]);
                }
            }
        }

        if (! empty($validated['students'])) {
            $module->assignedStudents()->attach($validated['students'], ['has_completed_user' => false]);
        }

        return back()->with('success', 'Modul erfolgreich erstellt.');
    }

    public function show(Module $module): \Illuminate\View\View
    {
        $module->load(['tasks', 'assignedStudents.tasks' => function ($query) use ($module) {
            $query->where('tasks.module_id', $module->module_id);
        }]);

        // Alle Lernenden des Supervisors laden, die noch NICHT diesem Modul zugewiesen sind
        $assignedUserIds = $module->assignedStudents->pluck('id')->toArray();
        $availableStudents = auth()->user()->students()
            ->whereNotIn('id', $assignedUserIds)
            ->get();

        return view('supervisor.modules.show', compact('module', 'availableStudents'));
    }

    public function assignStudents(\Illuminate\Http\Request $request, Module $module): RedirectResponse
    {
        $validated = $request->validate([
            'students' => ['required', 'array'],
            'students.*' => ['required', 'exists:users,id'],
        ]);

        $module->assignedStudents()->attach($validated['students'], ['has_completed_user' => false]);

        return back()->with('success', 'Lernende erfolgreich zugewiesen.');
    }

    public function toggleComplete(Module $module): RedirectResponse
    {
        if ($module->user_id !== auth()->id()) {
            abort(403);
        }

        $module->update([
            'is_completed' => ! $module->is_completed,
        ]);

        $message = $module->is_completed ? 'Kurs erfolgreich abgeschlossen.' : 'Kurs wieder geöffnet.';

        return back()->with('success', $message);
    }
}
