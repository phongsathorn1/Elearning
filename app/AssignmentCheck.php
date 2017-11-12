<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentCheck extends Model
{
    protected $fillable = [
        'user_id', 'assignment_id', 'score', 'returned'
    ];

    public function files()
    {
        return $this->hasMany('App\AssignmentFile', 'assignment_id', 'assignment_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
