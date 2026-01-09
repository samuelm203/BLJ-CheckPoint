<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModuleRequest;
use App\Models\Module;
use Illuminate\Http\RedirectResponse;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('tasks')->get();

        return view('modules.index', compact('modules'));
    }

    public function store(StoreModuleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $module = Module::create([
            'module_name' => $validated['module_name'],
            'description' => $validated['description'],
        ]);

        if (! empty($validated['tasks'])) {
            foreach ($validated['tasks'] as $taskTitle) {
                if (! empty($taskTitle)) {
                    $module->tasks()->create(['title' => $taskTitle]);
                }
            }
        }

        if (! empty($validated['students'])) {
            $module->completedByUsers()->attach($validated['students'], ['has_completed_user' => false]);
        }

        return back()->with('success', 'Modul erfolgreich erstellt.');
    }

    public function show(Module $module): \Illuminate\View\View
    {
        $module->load(['tasks', 'completedByUsers']);

        // Alle Lernenden des Supervisors laden, die noch NICHT diesem Modul zugewiesen sind
        $assignedUserIds = $module->completedByUsers->pluck('id')->toArray();
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

        $module->completedByUsers()->attach($validated['students'], ['has_completed_user' => false]);

        return back()->with('success', 'Lernende erfolgreich zugewiesen.');
    }
}
