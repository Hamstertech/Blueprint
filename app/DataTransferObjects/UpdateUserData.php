<?php

namespace App\DataTransferObjects;

use App\Enums\UserTypeEnum;
use App\Http\Requests\UpdateUserRequest;

class UpdateUserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly UserTypeEnum $role,
    ) {
    }

    public static function fromRequest(UpdateUserRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            role: UserTypeEnum::tryFrom($request->validated('role')) ?? UserTypeEnum::Guest,
        );
    }
}
