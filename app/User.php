<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    //Laravel "trait" (a bundle of functions)
    //this will automatically lookup the user and check for password match.
    use \Illuminate\Auth\Authenticatable;
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    //a user can have many likes/dislikes [
    // the users hitting like/dislike on several posts
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
