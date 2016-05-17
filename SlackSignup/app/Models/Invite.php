<?php

namespace App\Models;

use App\Models\UuidModel;

class Invite extends UuidModel
{
    protected $fillable = ['invitee_id', 'type'];

    public static function make($attributes){
        $invite = new Invite;
        return $invite->create($attributes);
    }

    public function invitee()
    {
        return $this->belongsTo('App\Models\Invitee');
    }
}
