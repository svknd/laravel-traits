<?php

namespace Svknd\Laravel\Traits\Models;

trait HasMultiLangName
{

    public $preventAttributeGet = false;

    public static function nameAttributeDefault()
    {
        return 'name';
    }

    public function getNameAttribute()
    {
        if (!$this->preventAttributeGet) {
            if (app()->isLocale('id') && $this->attributes['name_id']) {
                return $this->attributes['name_id'];
            } elseif (app()->isLocale('en') && $this->attributes['name_en']) {
                return $this->attributes['name_en'];
            } else {
                return $this->attributes[static::nameAttributeDefault()];
            }
        } else {
            return $this->attributes['name'];
        }
    }

    public static function getNameAttributeKey()
    {
        if (app()->isLocale('id')) {
            return 'name_id';
        } elseif (app()->isLocale('en')) {
            return 'name_en';
        } else {
            return static::nameAttributeDefault();
        }
    }

    public function scopeSearchByName($query, $search = null)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->orWhere(static::getNameAttributeKey(), 'ilike', "%{$search}%");
            });
        });
    }
}
