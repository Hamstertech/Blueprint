<?php

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('cannot update another user', function () {
    $admin = User::factory()->admin()->create();
    $admin2 = User::factory()->admin()->create();

    $data = [
        'name' => 'Test user',
        'email' => 'sky.etherington@ne6.studio',
        'role' => UserTypeEnum::Admin->value,
    ];

    actingAs($admin)
        ->putJson(route('users.update', [$admin2]), $data)
        ->assertForbidden();
});

it('updates a user', function () {
    $admin = User::factory()->admin()->create();

    $data = [
        'name' => 'Test user',
        'email' => 'sky.etherington@ne6.studio',
        'role' => UserTypeEnum::Admin->value,
    ];

    actingAs($admin)
        ->putJson(route('users.update', [$admin]), $data)
        ->assertJsonPath('data.name', $data['name'])
        ->assertJsonPath('data.email', $data['email'])
        ->assertJsonPath('data.role', $data['role'])
        ->assertOk();
});
