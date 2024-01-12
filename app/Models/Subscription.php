<?php

namespace App\Models;

use App\QueryBuilders\SubscriptionQueryBuilder;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    // --------------------------
    // QUERY BUILDER
    // --------------------------
    public static function query(): SubscriptionQueryBuilder
    {
        /** @var SubscriptionQueryBuilder $query */
        $query = parent::query();

        return $query;
    }

    public function newEloquentBuilder($query): SubscriptionQueryBuilder
    {
        return new SubscriptionQueryBuilder($query);
    }
}
