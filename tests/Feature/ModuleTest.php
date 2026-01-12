<?php

use App\Models\User;

test('supervisor can create a module', function () {
    $supervisor = User::factory()->create(['role' => 2]);

    $response = $this->actingAs($supervisor)
        ->post(route('supervisor.modules.store'), [
            'module_name' => 'Neuer Testkurs',
            'description' => 'Eine Testbeschreibung',
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('modules', [
        'module_name' => 'Neuer Testkurs',
        'description' => 'Eine Testbeschreibung',
        'user_id' => $supervisor->id,
    ]);
});

test('supervisor can only see their own modules on dashboard', function () {
    $supervisor1 = User::factory()->supervisor()->create();
    $supervisor2 = User::factory()->supervisor()->create();

    $module1 = \App\Models\Module::create(['module_name' => 'Kurs von Supervisor 1', 'user_id' => $supervisor1->id]);
    $module2 = \App\Models\Module::create(['module_name' => 'Kurs von Supervisor 2', 'user_id' => $supervisor2->id]);

    $response = $this->actingAs($supervisor1)
        ->get(route('supervisor.dashboard'));

    $response->assertOk();
    $response->assertSee('Kurs von Supervisor 1');
    $response->assertDontSee('Kurs von Supervisor 2');
});

test('supervisor can create a module with tasks and students', function () {
    $supervisor = User::factory()->supervisor()->create();
    $student = User::factory()->student()->create(['supervisor_id' => $supervisor->id]);

    $response = $this->actingAs($supervisor)
        ->post(route('supervisor.modules.store'), [
            'module_name' => 'Komplexer Kurs',
            'description' => 'Mit Tasks und Lernenden',
            'tasks' => ['Erste Aufgabe', 'Zweite Aufgabe'],
            'students' => [$student->id],
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('modules', ['module_name' => 'Komplexer Kurs']);
    $module = \App\Models\Module::where('module_name', 'Komplexer Kurs')->first();

    $this->assertDatabaseHas('tasks', ['title' => 'Erste Aufgabe', 'module_id' => $module->module_id]);
    $this->assertDatabaseHas('tasks', ['title' => 'Zweite Aufgabe', 'module_id' => $module->module_id]);

    $this->assertDatabaseHas('has_user_completed', [
        'user_id' => $student->id,
        'module_id' => $module->module_id,
    ]);
});

test('supervisor can view a module details', function () {
    $supervisor = User::factory()->supervisor()->create();
    $module = \App\Models\Module::create(['module_name' => 'Detail Kurs']);

    $response = $this->actingAs($supervisor)
        ->get(route('supervisor.modules.show', $module));

    $response->assertOk();
    $response->assertSee('Detail Kurs');
});

test('student cannot view a module details', function () {
    $student = User::factory()->student()->create();
    $module = \App\Models\Module::create(['module_name' => 'Geheimer Kurs']);

    $response = $this->actingAs($student)
        ->get(route('supervisor.modules.show', $module));

    $response->assertForbidden();
});

test('student cannot create a module', function () {
    $student = User::factory()->student()->create();

    $response = $this->actingAs($student)
        ->post(route('supervisor.modules.store'), [
            'module_name' => 'Studenten-Kurs',
        ]);

    $response->assertForbidden();
});

test('supervisor can assign students to a module from show page', function () {
    $supervisor = User::factory()->supervisor()->create();
    $student = User::factory()->student()->create(['supervisor_id' => $supervisor->id]);
    $module = \App\Models\Module::create(['module_name' => 'Zuweisungs Kurs']);

    $response = $this->actingAs($supervisor)
        ->post(route('supervisor.modules.assign-students', $module), [
            'students' => [$student->id],
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('has_user_completed', [
        'user_id' => $student->id,
        'module_id' => $module->module_id,
    ]);
});

test('student cannot assign students to a module', function () {
    $student = User::factory()->student()->create();
    $otherStudent = User::factory()->student()->create();
    $module = \App\Models\Module::create(['module_name' => 'Geheimer Kurs']);

    $response = $this->actingAs($student)
        ->post(route('supervisor.modules.assign-students', $module), [
            'students' => [$otherStudent->id],
        ]);

    $response->assertForbidden();
});
