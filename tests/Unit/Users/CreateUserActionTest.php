<?php

use App\Actions\CleanPhoneNumberAction;
use App\Actions\Users\CreateUserAction;
use App\DataTransferObjects\StoreUserData;
use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;

uses(RefreshDatabase::class);

it('can create admin action', function () {
    Event::fake();
    $data = new StoreUserData(
        name: 'Testerson',
        email: 'sky.etherington@ne6.studio',
        phone: '+447777777777',
        role: UserTypeEnum::Admin,
    );

    $action = new CreateUserAction(
        $this->mock(CleanPhoneNumberAction::class, function (MockInterface $mock) use ($data) {
            $mock->shouldReceive('execute')->once()->andReturn($data->phone);
        }),
    );

    $user = $action->execute($data);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toEqual($data->name);
    expect($user->email)->toEqual($data->email);
    expect($user->phone)->toEqual($data->phone);
    expect($user->role)->toEqual($data->role);

    Event::assertDispatched(Registered::class);
});

it('can create guest action', function () {
    Event::fake();
    $data = new StoreUserData(
        name: 'Testerson',
        email: 'sky.etherington@ne6.studio',
        phone: '+447777777777',
        role: UserTypeEnum::Guest,
    );

    $action = new CreateUserAction(
        $this->mock(CleanPhoneNumberAction::class, function (MockInterface $mock) use ($data) {
            $mock->shouldReceive('execute')->once()->andReturn($data->phone);
        }),
    );

    $user = $action->execute($data);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toEqual($data->name);
    expect($user->email)->toEqual($data->email);
    expect($user->phone)->toEqual($data->phone);
    expect($user->role)->toEqual($data->role);

    Event::assertDispatched(Registered::class);
});
