<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    //
    protected $fillable = [
        'user_id', 'name', 'description'
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function assignments()
    {
        return $this->hasMany('App\Assignment');
    }

    public function user()
    {
        return $this->belongsToMany('App\User');
    }
}
