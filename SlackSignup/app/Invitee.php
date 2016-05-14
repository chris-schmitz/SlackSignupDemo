<?php

namespace App;

use App\Models\UuidModel;

class Invitee extends UuidModel
{
    protected $fillable = ['first_name', 'last_name', 'email'];

    public function invites()
    {
        return $this->hasMany('App\Invite');
    }
}
