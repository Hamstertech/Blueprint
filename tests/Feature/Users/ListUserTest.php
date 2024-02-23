<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('lists users', function () {
    $admin = User::factory()->create();

    User::factory()
        ->count(14)
        ->create();

    actingAs($admin)
        ->getJson(route('users.index'))
        ->assertOk()
        ->assertJsonStructure([
            'meta',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'created_at',
                    'last_login',
                ],
            ],
        ])
        ->assertJsonCount(15, 'data');
});

it('lists searched users', function () {
    $admin = User::factory()->create();

    $user = User::factory()
        ->create(['name' => 'Timothy Blue']);

    User::factory()
        ->count(13)
        ->create();

    actingAs($admin)
        ->getJson(route('users.index', ['q' => $user->name]))
        ->assertOk()
        ->assertJsonStructure([
            'meta',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'created_at',
                    'last_login',
                ],
            ],
        ])
        ->assertJsonCount(1, 'data');
});
