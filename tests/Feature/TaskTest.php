<?php

use App\Models\Module;
use App\Models\User;

test('supervisor can add a task to a module', function () {
    $supervisor = User::factory()->supervisor()->create();
    $module = Module::create(['module_name' => 'Test Modul']);

    $response = $this->actingAs($supervisor)
        ->post(route('supervisor.tasks.store'), [
            'title' => 'Neue Aufgabe',
            'module_id' => $module->module_id,
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('tasks', [
        'title' => 'Neue Aufgabe',
        'module_id' => $module->module_id,
    ]);
});

test('student cannot add a task', function () {
    $student = User::factory()->create(['role' => 1]);
    $module = Module::create(['module_name' => 'Test Modul']);

    $response = $this->actingAs($student)
        ->post(route('supervisor.tasks.store'), [
            'title' => 'Student Aufgabe',
            'module_id' => $module->module_id,
        ]);

    $response->assertForbidden();
});
