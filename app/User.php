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
        'name', 'email', 'username', 'password', 'role_id'
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
        $avatar_url = '';
        if($this->attributes['avatar'])
        {
            $avatar_url = url('avatar/'.$this->attributes['id'].'/'.$this->attributes['avatar']);
        }
        else {
            $avatar_url = url('images/avatar.svg');
        }
        return $this->attributes['avatar_url'] = $avatar_url;
    }
}
