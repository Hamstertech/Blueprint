<?php

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    Notification::fake();
    Event::fake();
});

it('creates a user', function () {
    $admin = User::factory()->admin()->create();

    $data = [
        'name' => 'Test User',
        'email' => 'sky.etherington@ne6.studio',
        'role' => UserTypeEnum::Admin->value,
    ];

    actingAs($admin)
        ->postJson(route('users.store'), $data)
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
        ->assertJsonPath('data.name', $data['name'])
        ->assertJsonPath('data.email', $data['email'])
        ->assertJsonPath('data.role', $data['role'])
        ->assertCreated();

    Event::assertDispatched(Registered::class);
});
