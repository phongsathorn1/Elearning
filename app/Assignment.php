<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //
    protected $fillable = [
        'user_id', 'post_id', 'classroom_id', 'title', 'detail', 'due_time', 'score'
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

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function file()
    {
        return $this->hasMany('App\AssignmentFile');
    }
}
