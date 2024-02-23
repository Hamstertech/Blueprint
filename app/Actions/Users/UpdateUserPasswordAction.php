<?php

namespace App\Actions\Users;

use App\DataTransferObjects\UpdateUserPasswordData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordAction
{
    public function execute(UpdateUserPasswordData $data, User $user): User|string
    {
        if (Hash::check($data->current_password, $user->password)) {
            $user->password = Hash::make($data->password);
            $user->save();

            return $user->fresh();
        }

        return 'Wrong password.';
    }
}
