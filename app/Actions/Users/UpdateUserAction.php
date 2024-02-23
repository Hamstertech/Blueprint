<?php

namespace App\Actions\Users;

use App\DataTransferObjects\UpdateUserData;
use App\Models\User;

class UpdateUserAction
{
    public function execute(UpdateUserData $data, User $user): User
    {
        $user->name = $data->name;
        $user->email = $data->email;
        $user->role = $data->role;

        $user->save();

        return $user;
    }
}
