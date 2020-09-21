<?php

namespace Svknd\Laravel\Traits\Models;

use Svknd\Laravel\Traits\Models\Scope\IsActiveScope;

trait IsActive
{
    public static function bootIsActive()
    {
        static::addGlobalScope(new IsActiveScope());
    }
}
