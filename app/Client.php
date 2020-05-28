<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable=[
        "name",
        "type",
        "user_id"
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function clients(){
        return $this->hasMany('App\Client');
    }
    //
}
