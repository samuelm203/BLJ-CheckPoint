<?php

use App\Models\Module;
use App\Models\Task;
use App\Models\User;

it('allows supervisor to update their student', function () {
    $supervisor = User::factory()->supervisor()->create();
    $student = User::factory()->student()->create(['supervisor_id' => $supervisor->id]);

    $response = $this->actingAs($supervisor)->put(route('supervisor.students.update', $student), [
        'first_name' => 'Updated',
        'surname' => 'Name',
        'email' => 'updated@example.com',
    ]);

    $response->assertRedirect(route('supervisor.dashboard'));
    $this->assertDatabaseHas('users', [
        'id' => $student->id,
        'first_name' => 'Updated',
        'email' => 'updated@example.com',
    ]);
});

it('prevents supervisor from updating students of other supervisors', function () {
    $supervisor1 = User::factory()->supervisor()->create();
    $supervisor2 = User::factory()->supervisor()->create();
    $student = User::factory()->student()->create(['supervisor_id' => $supervisor2->id]);

    $response = $this->actingAs($supervisor1)->put(route('supervisor.students.update', $student), [
        'first_name' => 'Stolen',
        'surname' => 'Update',
        'email' => 'stolen@example.com',
    ]);

    $response->assertStatus(403);
});

it('allows supervisor to delete their student', function () {
    $supervisor = User::factory()->supervisor()->create();
    $student = User::factory()->student()->create(['supervisor_id' => $supervisor->id]);

    $response = $this->actingAs($supervisor)->delete(route('supervisor.students.destroy', $student));

    $response->assertRedirect(route('supervisor.dashboard'));
    $this->assertDatabaseMissing('users', ['id' => $student->id]);
});

it('shows progress on dashboard', function () {
    $supervisor = User::factory()->supervisor()->create();
    $student = User::factory()->student()->create(['supervisor_id' => $supervisor->id]);

    $module = Module::create([
        'module_name' => 'Test Module',
        'user_id' => $supervisor->id,
    ]);

    $task1 = Task::create(['title' => 'Task 1', 'module_id' => $module->module_id]);
    $task2 = Task::create(['title' => 'Task 2', 'module_id' => $module->module_id]);

    $module->assignedStudents()->attach($student->id);

    // Complete one task
    $student->tasks()->attach($task1->task_id, ['is_completed' => true, 'completion_date' => now()]);
    $student->tasks()->attach($task2->task_id, ['is_completed' => false]);

    $response = $this->actingAs($supervisor)->get(route('supervisor.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('1 / 2 Aufgaben');
    $response->assertSee('50%');
});
