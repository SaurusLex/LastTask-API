<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        "title",
        "description",
        "estimated_duration",
        "duration",
        "project_id",
        "status"
    ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
