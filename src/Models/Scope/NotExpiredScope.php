<?php

namespace Svknd\Laravel\Traits\Models\Scope;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class NotExpiredScope implements Scope
{

    protected $extensions = ['WithExpired', 'WithoutExpired', 'OnlyExpired'];

    public function apply(Builder $builder, Model $model)
    {
        $builder->where(function (Builder $query) {
            $query->whereNull('start_date')
                ->orWhere('start_date', '<=', Carbon::now()->format('Y-m-d'));
        })->where(function (Builder $query) {
            $query->whereNull('end_date')
                ->orWhere('end_date', '>', Carbon::now()->format('Y-m-d'));
        });
    }

    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithExpired(Builder $builder)
    {
        $builder->macro('withExpired', function (Builder $builder, $withExpired = true) {
            if (!$withExpired) {
                return $builder->withoutExpired();
            }
            return $builder->withoutGlobalScope($this);
        });
    }

    protected function addWithoutExpired(Builder $builder)
    {
        $builder->macro('withoutExpired', function (Builder $builder) {
            $builder->where(function (Builder $query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', Carbon::now()->format('Y-m-d'));
            })->where(function (Builder $query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>', Carbon::now()->format('Y-m-d'));
            });
            return $builder;
        });
    }

    protected function addOnlyExpired(Builder $builder)
    {
        $builder->macro('onlyExpired', function (Builder $builder) {
            $builder->withoutGlobalScope($this)
                ->where('end_date', '<', Carbon::now()->format('Y-m-d'));
            return $builder;
        });
    }
}
