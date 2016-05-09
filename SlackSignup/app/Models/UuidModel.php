<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UuidModel extends Model
{
    protected $uuid;

    public $incrementing = false;

    protected function setUuid()
    {
        $uuid = Uuid::uuid1()->toString();
        $this->id = $uuid;
    }
}
