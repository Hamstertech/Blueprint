<?php

namespace App\Actions;

use App\DataTransferObjects\UpdateUserData;
use App\Models\User;

class UpdateUserAction
{
    public function __construct(
        protected CleanPhoneNumberAction $cleanPhoneNumberAction,
    ) {
    }

    public function execute(UpdateUserData $data, User $user): User
    {
        $user->name = $data->name;
        $user->email = $data->email;
        $user->phone = $this->cleanPhoneNumberAction->execute($data->phone);
        $user->role = $data->role;

        $user->save();

        return $user;
    }
}
