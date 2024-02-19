<?php

use App\Models\User;
use App\Services\FrontendService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('email can be verified', function () {
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
        ->assertJsonPath('message', 'Successfully verified.');

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

it('email is not verified with invalid token', function () {
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
