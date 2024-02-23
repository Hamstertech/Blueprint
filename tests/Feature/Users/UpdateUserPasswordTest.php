<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('can update a users password', function () {
    $user = User::factory()->create(['password' => 'testpassword1']);

    $data = [
        'current_password' => 'testpassword1',
        'password' => 'hellopassword',
        'password_confirmation' => 'hellopassword',
    ];

    actingAs($user)
        ->postJson(route('users.password', [$user]), $data)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'role',
                'last_login',
                'email_verified_at',
                'created_at',
            ],
        ])
        ->assertJsonPath('data.name', $user->name)
        ->assertJsonPath('data.email', $user->email)
        ->assertJsonPath('data.role', $user->role->value)
        ->assertOk();
});

it('can return error if the password is wrong', function () {
    $user = User::factory()->create(['password' => 'testpassword1']);

    $data = [
        'current_password' => 'testerson',
        'password' => 'hellopassword',
        'password_confirmation' => 'hellopassword',
    ];

    actingAs($user)
        ->postJson(route('users.password', [$user]), $data)
        ->assertJsonPath('message', 'Wrong password.')
        ->assertUnauthorized();
});
