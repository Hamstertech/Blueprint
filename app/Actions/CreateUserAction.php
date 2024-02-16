<?php

namespace App\Actions;

use App\DataTransferObjects\StoreUserData;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUserAction
{
    public function __construct(
        protected CleanPhoneNumberAction $cleanPhoneNumberAction,
    ) {
    }

    public function execute(StoreUserData $data): User
    {
        $user = new User;
        $user->name = $data->name;
        $user->email = $data->email;
        $user->phone = $this->cleanPhoneNumberAction->execute($data->phone);
        $user->role = $data->role;
        $user->password = Hash::make(Str::random(60));

        $user->save();

        event(new Registered($user));

        return $user;
    }
}
