<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $hidden = [
        'id', 'actions'
    ];

    protected $fillable = [
        'name', 'actions'
    ];
}
