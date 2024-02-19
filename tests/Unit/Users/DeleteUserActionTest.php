<?php

use App\Actions\Users\DeleteUserAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('deletes guest user action', function () {
    $user = User::factory()->create(['password' => 'testpassword']);
    $action = new DeleteUserAction;
    $res = $action->execute($user);

    expect($res)->toBeTruthy();
});

it('deletes admin user action', function () {
    $user = User::factory()->admin()->create();
    $action = new DeleteUserAction;
    $res = $action->execute($user);

    expect($res)->toBeTruthy();
});
