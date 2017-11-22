<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'role_id', 'avatar'
    ];

    protected $appends = [
        'avatar_url'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role_id'
    ];

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function post()
    {
        return $this->hasMany('App\Post');
    }

    public function classroom()
    {
        return $this->belongsToMany('App\Classroom');
    }

    public function ownClassroom()
    {
        return $this->hasMany('App\Classroom');
    }

    public function assignments()
    {
        return $this->hasMany('App\Assignment');
    }

    public function getAvatarUrlAttribute()
    {
        if($this->avatar)
        {
            $avatar_url = url('avatar/'.$this->id.'/'.$this->avatar);
        }
        else{
            $avatar_url = url('images/avatar.svg');
        }

        return $avatar_url;
    }
}
