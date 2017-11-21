<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    //
    protected $fillable = [
        'user_id', 'name', 'description', 'join_code'
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
        $cover_url = '';
        if($this->attributes['cover'])
        {
            $cover_url = url('classroom/'.$this->attributes['id'].'/'.$this->attributes['cover']);
        }
        else {
            $cover_url = url('images/classroom.svg');
        }
        return $this->attributes['cover_url'] = $cover_url;
    }
}
