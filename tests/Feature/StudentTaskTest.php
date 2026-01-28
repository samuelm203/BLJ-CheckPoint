<?php

use App\Models\Module;
use App\Models\Task;
use App\Models\User;

it('allows a student to toggle a task completion', function () {
    $supervisor = User::factory()->supervisor()->create();
    $student = User::factory()->student()->create(['supervisor_id' => $supervisor->id]);
    $module = Module::create([
        'module_name' => 'Test Module',
        'user_id' => $supervisor->id,
    ]);
    $task = Task::create(['title' => 'Test Task', 'module_id' => $module->module_id]);

    $module->assignedStudents()->attach($student->id);

    // Initial state: not completed
    $this->actingAs($student)
        ->post(route('student.tasks.toggle', $task))
        ->assertRedirect();

    $this->assertDatabaseHas('task_user', [
        'user_id' => $student->id,
        'task_id' => $task->task_id,
        'is_completed' => true,
    ]);

    // Toggle back to not completed
    $this->actingAs($student)
        ->post(route('student.tasks.toggle', $task))
        ->assertRedirect();

    $this->assertDatabaseHas('task_user', [
        'user_id' => $student->id,
        'task_id' => $task->task_id,
        'is_completed' => false,
    ]);
});

it('prevents student from toggling tasks of unassigned modules', function () {
    $student = User::factory()->student()->create();
    $module = Module::create([
        'module_name' => 'Other Module',
        'user_id' => User::factory()->supervisor()->create()->id,
    ]);
    $task = Task::create(['title' => 'Other Task', 'module_id' => $module->module_id]);

    $this->actingAs($student)
        ->post(route('student.tasks.toggle', $task))
        ->assertStatus(403);
});

it('shows student progress to supervisor in module view', function () {
    $supervisor = User::factory()->supervisor()->create();
    $student = User::factory()->student()->create(['supervisor_id' => $supervisor->id]);
    $module = Module::create([
        'module_name' => 'Progress Module',
        'user_id' => $supervisor->id,
    ]);
    $task = Task::create(['title' => 'Task A', 'module_id' => $module->module_id]);

    $module->assignedStudents()->attach($student->id);
    $student->tasks()->attach($task->task_id, ['is_completed' => true, 'completion_date' => now()]);

    $response = $this->actingAs($supervisor)->get(route('supervisor.modules.show', $module));

    $response->assertStatus(200);
    $response->assertSee($student->first_name);
    $response->assertSee('1 / 1 Aufgaben');
    $response->assertSee('Task A');
});
