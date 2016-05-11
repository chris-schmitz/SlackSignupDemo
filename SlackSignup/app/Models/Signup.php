<?php

namespace App\Models;

class Signup extends UuidModel
{
    protected $fillable = ['first_name', 'last_name', 'email'];
    protected $records = [];

    public function exists($email)
    {
        $this->records = $this->where('email', $email)->first();
        return $this;
    }

    public function count()
    {
        return count($this->records);
    }

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
