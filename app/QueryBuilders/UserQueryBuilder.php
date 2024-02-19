<?php

namespace App\QueryBuilders;

use App\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function userType(?string $type = null): self
    {
        return $this->when($type, fn (self $builder) => $builder->where(function (self $query) use ($type) {
            $query->where('role', $type);
        }));
    }

    public function search(?string $q = null): self
    {
        return $this->when($q, fn (self $builder) => $builder->where(function (self $query) use ($q) {
            $query->where('name', 'LIKE', ["%$q%"])
                ->orWhere('email', 'LIKE', ["%$q%"])
                ->orWhere('phone', 'LIKE', ["%$q%"]);
        }));
    }

    public function guest(): self
    {
        return $this->where('role', UserTypeEnum::Guest->value);
    }

    public function admin(): self
    {
        return $this->where('role', UserTypeEnum::Admin->value);
    }
}
