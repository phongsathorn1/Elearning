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
        return $this->hasMany('App\AssignmentFile', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
