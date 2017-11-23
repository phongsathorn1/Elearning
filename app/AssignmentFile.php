<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentFile extends Model
{
    protected $fillable = [
        'user_id', 'assignment_id', 'name', 'location'
    ];

    public function assignment()
    {
        return $this->belongsTo('App\Assignment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
