<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

it('can verify email', function () {
    Event::fake();
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $token = sha1($user->getEmailForVerification());

    $data = [
        'id' => $user->id,
        'token' => $token,
        'password' => 'testpassword',
        'password_confirmation' => 'testpassword',
    ];

    $this->postJson(route('verification.verify'), $data)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'role',
                'created_at',
                'last_login',
                'email_verified_at',
                'token',
            ],
        ]);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

it('can not verify email with invalid token', function () {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    $token = sha1('somerandomemail@test.test');

    $data = [
        'id' => $user->id,
        'token' => $token,
        'password' => 'testpassword',
        'password_confirmation' => 'testpassword',
    ];

    $this->postJson(route('verification.verify'), $data)
        ->assertJsonPath('message', 'This action is unauthorized.');

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
