<?php

namespace App\DataTransferObjects;

use App\Enums\UserTypeEnum;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\StoreUserRequest;

class StoreUserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly UserTypeEnum $role,
    ) {
    }

    public static function fromRequest(RegisterUserRequest|StoreUserRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            role: UserTypeEnum::tryFrom($request->validated('role')) ?? UserTypeEnum::Guest,
        );
    }
}
