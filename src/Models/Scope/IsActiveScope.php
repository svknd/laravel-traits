<?php

namespace Svknd\Laravel\Traits\Models\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IsActiveScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('is_active', true);
    }
}
