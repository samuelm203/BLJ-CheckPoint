<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a test user
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'max@example.com'],
            [
                'first_name' => 'Max',
                'surname' => 'Mustermann',
                'password' => bcrypt('password'),
                'role' => 1,
            ]
        );

        // 2. Create a test module
        $module = \App\Models\Module::create([
            'module_name' => 'Einführung in Laravel',
            'description' => 'Lerne die Grundlagen des Frameworks.',
        ]);

        // 3. Create some tasks for the test module
        $task1 = $module->tasks()->create(['title' => 'Installation']);
        $task2 = $module->tasks()->create(['title' => 'Erste Migration']);
        $task3 = $module->tasks()->create(['title' => 'Datenbank-Seeding']);

        // 4. Connect the tasks to the user
        $user->tasks()->attach($task1->task_id, [
            'is_completed' => true,
            'completion_date' => now(),
        ]);

        // 5. Create more tasks to test the connection between the web and the database
        $task2 = $module->tasks()->create(['title' => 'Datenbank-Seeding']);

    }
}
