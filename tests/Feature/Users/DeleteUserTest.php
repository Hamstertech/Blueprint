<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('deletes a user as an admin', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    actingAs($admin)
        ->deleteJson(route('users.destroy', [$user]))
        ->assertOk();
});
