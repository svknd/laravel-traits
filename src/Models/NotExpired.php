<?php

namespace Svknd\Laravel\Traits\Models;

use Svknd\Laravel\Traits\Models\Scope\NotExpiredScope;

trait NotExpired
{
    public static function bootNotExpired()
    {
        static::addGlobalScope(new NotExpiredScope());
    }
}
