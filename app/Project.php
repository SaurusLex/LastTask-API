<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    public function client(){
        return $this->belongsTo('App\Client');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function tasks(){
        return $this->hasMany('App\Task');
    }
    protected $fillable=[
        "title",
        "description",
        "client_id",
        "user_id",
        "cost_per_hour",
        "img_src",
        "finish_date",
        "status"
    ];
    protected $hidden=[
        "client_id"
    ];
}
