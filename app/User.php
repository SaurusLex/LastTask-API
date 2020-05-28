<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    //
    protected $fillable = [
        "email",
        "password",
        "name"
    ];
    //protected $hidden = ["password"];
    public function projects()
    {
        return $this->hasMany('App\Project');
    }
    public function clients()
    {
        return $this->hasMany('App\Client');
    }
}
