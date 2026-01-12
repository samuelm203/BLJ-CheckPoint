<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Create a supervisor
        $supervisor = \App\Models\User::updateOrCreate(
            ['email' => 'supervisor@example.com'],
            [
                'first_name' => 'Stefan',
                'surname' => 'Supervisor',
                'password' => bcrypt('password'),
                'role' => 2,
            ]
        );

        // 2. Create a test student assigned to the supervisor
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'max@example.com'],
            [
                'first_name' => 'Max',
                'surname' => 'Mustermann',
                'password' => bcrypt('password'),
                'role' => 1,
                'supervisor_id' => $supervisor->id,
            ]
        );

        // 3. Create another student without supervisor (for testing)
        \App\Models\User::updateOrCreate(
            ['email' => 'allein@example.com'],
            [
                'first_name' => 'Anna',
                'surname' => 'Allein',
                'password' => bcrypt('password'),
                'role' => 1,
                'supervisor_id' => null,
            ]
        );

        // 4. Create a test module
        $module = \App\Models\Module::create([
            'module_name' => 'Einführung in Laravel',
            'description' => 'Lerne die Grundlagen des Frameworks.',
        ]);

        // 5. Create tasks for the test module
        $task1 = $module->tasks()->create(['title' => 'Installation']);
        $task2 = $module->tasks()->create(['title' => 'Erste Migration']);
        $task3 = $module->tasks()->create(['title' => 'Datenbank-Seeding']);
        $task4 = $module->tasks()->create(['title' => 'Eloquent ORM']);
        $task5 = $module->tasks()->create(['title' => 'Routen und Controller']);
        $task6 = $module->tasks()->create(['title' => 'Blade Templates']);

        // 6. Connect all tasks to the user with different completion statuses
        $user->tasks()->attach([
            $task1->getKey() => ['is_completed' => true,  'completion_date' => now()],
            $task2->getKey() => ['is_completed' => false, 'completion_date' => null],
            $task3->getKey() => ['is_completed' => false, 'completion_date' => null],
            $task4->getKey() => ['is_completed' => false, 'completion_date' => null],
            $task5->getKey() => ['is_completed' => false, 'completion_date' => null],
            $task6->getKey() => ['is_completed' => false, 'completion_date' => null],
        ]);

        // 7. Create another test module
        $module = \App\Models\Module::create([
            'module_name' => 'Testmodul 2',
            'description' => 'Testmodul Beschreibung.',
        ]);

        // 8. Mark the second module as completed for the user
        $user->assignedModules()->attach($module->module_id, [
            'has_completed_user' => true,
        ]);

    }
}
