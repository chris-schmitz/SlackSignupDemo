<?php

namespace App\Models\Foundations;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{

    public static function make($attributes)
    {
        $instance = new static;
        collect($attributes)->each(function ($attribute, $field) use ($instance) {
            $instance->{$field} = $attribute;
        });
        return $instance;
    }

}
