<?php

use App\Actions\Users\CreateUserAction;
use App\DataTransferObjects\StoreUserData;
use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

it('can create admin action', function () {
    Event::fake();
    $data = new StoreUserData(
        name: 'Testerson',
        email: 'sky.etherington@ne6.studio',
        role: UserTypeEnum::Admin,
    );

    $action = new CreateUserAction();

    $user = $action->execute($data);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toEqual($data->name);
    expect($user->email)->toEqual($data->email);
    expect($user->role)->toEqual($data->role);

    Event::assertDispatched(Registered::class);
});

it('can create guest action', function () {
    Event::fake();
    $data = new StoreUserData(
        name: 'Testerson',
        email: 'sky.etherington@ne6.studio',
        role: UserTypeEnum::Guest,
    );

    $action = new CreateUserAction();

    $user = $action->execute($data);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toEqual($data->name);
    expect($user->email)->toEqual($data->email);
    expect($user->role)->toEqual($data->role);

    Event::assertDispatched(Registered::class);
});
