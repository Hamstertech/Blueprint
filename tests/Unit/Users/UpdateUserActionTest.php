<?php

use App\Actions\Users\UpdateUserAction;
use App\DataTransferObjects\UpdateUserData;
use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can update admin action', function () {
    $admin = User::factory()->admin()->create();

    $data = new UpdateUserData(
        name: 'Testerson',
        email: 'test@test.test',
        role: UserTypeEnum::Admin,
    );

    $action = new UpdateUserAction();

    $user = $action->execute($data, $admin);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toEqual($data->name);
    expect($user->email)->toEqual($data->email);
    expect($user->role)->toEqual($data->role);
});

it('can update guest action', function () {
    $guest = User::factory()->guest()->create();

    $data = new UpdateUserData(
        name: 'Testerson',
        email: 'test@test.test',
        role: UserTypeEnum::Guest
    );

    $action = new UpdateUserAction();

    $user = $action->execute($data, $guest);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toEqual($data->name);
    expect($user->email)->toEqual($data->email);
    expect($user->role)->toEqual($data->role);
});
