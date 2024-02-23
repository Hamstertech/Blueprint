<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('shows a user', function () {
    $admin = User::factory()->create();
    $user = User::factory()->create();

    actingAs($admin)
        ->getJson(route('users.show', [$user]))
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'role',
                'created_at',
                'last_login',
            ],
        ])
        ->assertJsonPath('data.id', $user->id)
        ->assertJsonPath('data.name', $user->name)
        ->assertJsonPath('data.email', $user->email)
        ->assertJsonPath('data.role', $user->role->value)
        ->assertJsonPath('data.created_at', Carbon::parse($user->created_at)->setTimezone('UTC')->format('Y-m-d\TH:i:s.u\Z'))
        ->assertJsonPath('data.last_login', null)
        ->assertJsonPath('data.email_verified_at', Carbon::parse($user->email_verified_at)->setTimezone('UTC')->format('Y-m-d\TH:i:s.u\Z'))
        ->assertOk();
});
