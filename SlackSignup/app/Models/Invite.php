<?php

namespace App\Models;

use App\Models\UuidModel;

class Invite extends UuidModel
{
    protected $fillable = ['invitee_id', 'type'];

    public function invitee()
    {
        return $this->belongsTo('App\Models\Invitee');
    }
}
