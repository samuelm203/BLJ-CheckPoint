<?php

use App\Models\User;

test('supervisor can create a student', function () {
    $supervisor = User::factory()->create(['role' => 2]);

    $response = $this->actingAs($supervisor)
        ->post(route('supervisor.students.store'), [
            'first_name' => 'Max',
            'surname' => 'Mustermann',
            'email' => 'max@example.com',
            'password' => 'password123',
        ]);

    $response->assertRedirect(route('supervisor.dashboard'));
    $this->assertDatabaseHas('users', [
        'first_name' => 'Max',
        'surname' => 'Mustermann',
        'email' => 'max@example.com',
        'role' => 1,
        'supervisor_id' => $supervisor->id,
    ]);
});

test('student cannot create another student', function () {
    $student = User::factory()->create(['role' => 1]);

    $response = $this->actingAs($student)
        ->post(route('supervisor.students.store'), [
            'first_name' => 'Evil',
            'surname' => 'Student',
            'email' => 'evil@example.com',
            'password' => 'password123',
        ]);

    $response->assertForbidden();
});
