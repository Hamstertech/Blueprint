<?php

use App\Actions\CleanPhoneNumberAction;
use App\Actions\Users\UpdateUserAction;
use App\DataTransferObjects\UpdateUserData;
use App\Enums\UserTypeEnum;
use App\Models\User;
use Mockery\MockInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('update admin action', function () {
    $admin = User::factory()->admin()->create();

    $data = new UpdateUserData(
        name: 'Testerson',
        email: 'test@test.test',
        phone: '+447777777777',
        role: UserTypeEnum::Admin,
    );

    $action = new UpdateUserAction(
        $this->mock(CleanPhoneNumberAction::class, function (MockInterface $mock) use ($data) {
            $mock->shouldReceive('execute')->once()->andReturn($data->phone);
        }),
    );

    $user = $action->execute($data, $admin);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toEqual($data->name);
    expect($user->email)->toEqual($data->email);
    expect($user->phone)->toEqual($data->phone);
    expect($user->role)->toEqual($data->role);
});

it('update guest action', function () {
    $guest = User::factory()->guest()->create();

    $data = new UpdateUserData(
        name: 'Testerson',
        email: 'test@test.test',
        phone: '+447777777777',
        role: UserTypeEnum::Guest
    );

    $action = new UpdateUserAction(
        $this->mock(CleanPhoneNumberAction::class, function (MockInterface $mock) use ($data) {
            $mock->shouldReceive('execute')->once()->andReturn($data->phone);
        }),
    );

    $user = $action->execute($data, $guest);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toEqual($data->name);
    expect($user->email)->toEqual($data->email);
    expect($user->phone)->toEqual($data->phone);
    expect($user->role)->toEqual($data->role);
});
