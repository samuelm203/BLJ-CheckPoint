<?php

use App\Models\User;

it('redirects guests from protected dashboard to login', function () {
    $response = $this->get('/student/dashboard');
    $response->assertRedirect('/student/login-redirect');

    $response = $this->get('/supervisor/dashboard');
    $response->assertRedirect('/student/login-redirect');
});

it('allows authenticated students to see student dashboard', function () {
    $user = User::factory()->student()->create();

    $response = $this->actingAs($user)->get('/student/dashboard');

    $response->assertStatus(200);
});

it('prevents students from seeing supervisor dashboard', function () {
    $user = User::factory()->student()->create();

    $response = $this->actingAs($user)->get('/supervisor/dashboard');

    $response->assertStatus(403);
});

it('allows logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});

it('redirects logged in users from login page to dashboard', function () {
    $user = User::factory()->student()->create();

    $response = $this->actingAs($user)->get('/student/login');

    $response->assertRedirect('/student/dashboard');
});

it('remembers user if remember me is checked', function () {
    $password = 'password123';
    $user = User::factory()->create([
        'password' => bcrypt($password),
        'role' => '1',
    ]);

    $response = $this->post('/student/login', [
        'email' => $user->email,
        'password' => $password,
        'remember' => 'on',
    ]);

    $response->assertRedirect('/student/dashboard');

    $this->assertAuthenticatedAs($user);
});

it('hides the current page link in the navbar', function () {
    $this->get(route('home'))
        ->assertDontSee('class="text-white hover:text-gray-300">Login</a>', false);

    $this->get(route('contact'))
        ->assertDontSee('class="text-white hover:text-gray-300">Kontakt</a>', false)
        ->assertSee('Über Mich')
        ->assertSee('Login');

    $this->get(route('about'))
        ->assertDontSee('class="text-white hover:text-gray-300">Über Mich</a>', false)
        ->assertSee('Kontakt')
        ->assertSee('Login');
});

it('hides contact and about links for logged in users', function () {
    $user = User::factory()->student()->create();

    $this->actingAs($user)->get(route('student.dashboard'))
        ->assertDontSee('Kontakt')
        ->assertDontSee('Über Mich')
        ->assertDontSee('Dashboard') // Hides current page link
        ->assertSee('Logout');
});
