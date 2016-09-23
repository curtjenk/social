<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    //a post can have many likes/dislikes [many users hitting like/dislike]
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
