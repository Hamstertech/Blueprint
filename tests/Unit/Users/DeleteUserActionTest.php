<?php

use App\Actions\Users\DeleteUserAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can delete guest user action', function () {
    $user = User::factory()->create();
    $action = new DeleteUserAction;
    $res = $action->execute($user);

    expect($res)->toBeTrue();
});
