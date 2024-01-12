<?php

namespace App\QueryBuilders;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function auth(?User $user): self
    {
        return $this;
    }

    public function type(UserTypeEnum $userType): self
    {
        return $this->where('user_type', $userType->value);
    }

    public function admin(): self
    {
        return $this->type(UserTypeEnum::Admin);
    }

    public function filter(string $q = null): self
    {
        return $this->when($q, fn (self $builder) => $builder->where('name', 'LIKE', ["%$q%"]));
    }
}
