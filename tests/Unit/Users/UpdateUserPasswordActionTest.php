<?php

use App\Actions\Users\UpdateUserPasswordAction;
use App\DataTransferObjects\UpdateUserPasswordData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can update user password action', function () {
    $admin = User::factory()->admin()->create(['password' => 'old_password']);
    $password = $admin->password;
    $data = new UpdateUserPasswordData(
        current_password: 'old_password',
        password: 'new_password',
    );

    $action = new UpdateUserPasswordAction();
    $res = $action->execute($data, $admin);

    expect($res)->toBeInstanceOf(User::class);
    expect($res->password)->not()->toBe($password);
});

it('can notify if password is wrong action', function () {
    $guest = User::factory()->guest()->create();
    $data = new UpdateUserPasswordData(
        current_password: 'Testerson',
        password: 'Testerson',
    );

    $action = new UpdateUserPasswordAction();
    $res = $action->execute($data, $guest);

    expect($res)->toBe('Wrong password.');
});
