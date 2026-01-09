<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        Task::create($request->validated());

        return back()->with('success', 'Aufgabe erfolgreich erstellt.');
    }
}
