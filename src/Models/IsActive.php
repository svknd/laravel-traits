<?php

namespace Svknd\Laravel\Traits\Models;

use App\Scope\IsActiveScope;

trait IsActive
{
    public static function bootIsActive()
    {
        static::addGlobalScope(new IsActiveScope());
    }
}
