<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('gets a dropdown list of users', function () {
    $admin = User::factory()->create();

    User::factory()->count(27)->create();

    actingAs($admin)
        ->getJson(route('users.dropdown'))
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'value',
                    'text',
                ],
            ],
        ])
        ->assertJsonCount(28, 'data');
});
