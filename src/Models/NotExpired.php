<?php

namespace Svknd\Laravel\Traits\Models;

use App\Scope\NotExpiredScope;

trait NotExpired
{
    public static function bootNotExpired()
    {
        static::addGlobalScope(new NotExpiredScope());
    }
}
