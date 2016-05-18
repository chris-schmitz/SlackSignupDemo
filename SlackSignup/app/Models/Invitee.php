<?php

namespace App\Models;

use App\Models\UuidModel;

class Invitee extends UuidModel
{
    protected $fillable = ['first_name', 'last_name', 'email'];
    protected $model;

    public static function make($attributes = []){
        $invitee = new Invitee;
        return $invitee->create($attributes);
    }

    public function exists($email)
    {
        if (empty($this->model)) {
            $this->byEmail($email);
        }
        return $this->model->count() > 0;
    }

    public function byEmail($email)
    {
        $this->model = $this->where('email', $email)->get();
        return $this;
    }

    public function invites()
    {
        return $this->hasMany('App\Models\Invite');
    }

    public function getId(){
        return $this->id;
    }

    public function fullName(){
        return $this->first_name . " " . $this->last_name;
    }

    public function firstName(){
        return $this->first_name;
    }

    public function email(){
        return $this->email;
    }
}
