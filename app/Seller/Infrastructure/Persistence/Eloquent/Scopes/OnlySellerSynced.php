<?php

namespace App\Seller\Infrastructure\Persistence\Eloquent\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
class OnlySellerSynced implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->whereNotNull('alegra_id');
    }
}
