<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $this->postJson(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'role',
                'created_at',
                'email_verified_at',
                'last_login',
                'token',
            ],
        ])
        ->assertJsonPath('data.id', $user->id)
        ->assertJsonPath('data.name', $user->name)
        ->assertJsonPath('data.email', $user->email)
        ->assertJsonPath('data.role', $user->role->value)
        ->assertJsonPath('data.created_at', Carbon::parse($user->created_at)->setTimezone('UTC')->format('Y-m-d\TH:i:s.u\Z'))
        ->assertJsonPath('data.email_verified_at', Carbon::parse($user->email_verified_at)->setTimezone('UTC')->format('Y-m-d\TH:i:s.u\Z'));

    $this->assertAuthenticated();
});

it('can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->postJson(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

it('can logout', function () {
    $user = User::factory()->create();

    $res = $this->postJson(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->withHeader('Authorization', 'Bearer '.$res['data']['token'])
        ->actingAs($user, 'sanctum')
        ->withMiddleware()
        ->postJson(route('logout'))
        ->assertJsonPath('message', 'Logged out.');
});
