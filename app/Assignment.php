<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //
    protected $fillable = [
        'user_id', 'classroom_id', 'title', 'detail', 'due_time'
    ];

    protected $appends = ['type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getTypeAttribute()
    {
        return 'assignment';
    }

    public function file()
    {
        return $this->hasMany('App\AssignmentFile');
    }
}
