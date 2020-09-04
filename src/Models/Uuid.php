<?php

namespace Svknd\Laravel\Traits\Models;

use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as UuidGenerator;

trait Uuid
{
    public function getKeyType()
    {
        return 'string';
    }

    public function getIncrementing()
    {
        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                if (!isset($model->id)) {
                    $model->id = UuidGenerator::uuid4()->toString();
                }
            } catch (UnsatisfiedDependencyException $e) { // @codeCoverageIgnoreStart
                abort(500, $e->getMessage());
            }  // @codeCoverageIgnoreEnd
        });

        static::replicating(function ($model) {
            try {
                if (!isset($model->id)) {
                    $model->id = UuidGenerator::uuid4()->toString();
                }
            } catch (UnsatisfiedDependencyException $e) { // @codeCoverageIgnoreStart
                abort(500, $e->getMessage());
            }  // @codeCoverageIgnoreEnd
        });
    }
}
