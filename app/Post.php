<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Traits\Likeable;
use App\Traits\Friendable;

class Post extends Model
{
    use Likeable,Friendable;

    protected $fillable = ['user_id','body','status','images'];

    public $with = ['user','likes','comments'];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function likes(){

        return $this->hasMany(Like::class);

    }

    public function comments(){

        return $this->hasMany(Comment::class);
    }
    
}
