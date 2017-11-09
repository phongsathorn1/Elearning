<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'classroom_id', 'type', 'detail'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
