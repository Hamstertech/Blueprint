<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class SubscriptionQueryBuilder extends Builder
{
    public function search(string $q = null): self
    {
        return $this->when($q, fn (self $builder) => $builder->where('name', 'LIKE', ["%$q%"]));
    }
}
