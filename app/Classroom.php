<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    //
    protected $fillable = [
        'user_id', 'name', 'description', 'join_code', 'cover'
    ];

    protected $appends = [
        'cover_url'
    ];

    protected $hidden = ['assignments', 'posts'];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function assignments()
    {
        return $this->hasMany('App\Assignment');
    }

    public function members()
    {
        return $this->belongsToMany('App\User');
    }

    public function getCoverUrlAttribute()
    {
        if($this->cover)
        {
            $cover_url = url('classroom/'.$this->id.'/'.$this->cover);
        }
        else {
            $cover_url = url('images/classroom.svg');
        }
        return $cover_url;
    }
}
