<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UpdateUserPasswordRequest;

class UpdateUserPasswordData
{
    public function __construct(
        public readonly string $current_password,
        public readonly string $password,
    ) {
    }

    public static function fromRequest(UpdateUserPasswordRequest $request): self
    {
        return new self(
            current_password: $request->validated('current_password'),
            password: $request->validated('password'),
        );
    }
}
