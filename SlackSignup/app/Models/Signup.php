<?php

namespace App\Models;

class Signup extends UuidModel
{
    protected $fillable = ['first_name', 'last_name', 'email'];

    public function persist($signupData)
    {
        $this->setUuid();

        $me = $this;
        collect($signupData)->each(function ($value, $key) use ($me) {
            $me->{$key} = $value;
        });

        $this->save();
        return $this;
    }
}
