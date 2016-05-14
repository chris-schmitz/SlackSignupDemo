<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UuidModel extends Model
{
    protected $uuid;

    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        static::creating(function ($model) {
            $model->setUuid();
        });
    }

    protected function setUuid()
    {
        $uuid = Uuid::uuid1()->toString();
        $this->id = $uuid;
    }
}
