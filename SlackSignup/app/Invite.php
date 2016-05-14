<?php

namespace App;

use App\Models\UuidModel;

class Invite extends UuidModel
{
    protected $fillable = ['invitee_id', 'type'];

    public function invitee()
    {
        return $this->belongsTo('App\Invitee');
    }
}
