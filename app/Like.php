<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Likeable;

class Like extends Model
{

    use Likeable;

    protected $fillable = ['user_id','post_id','liked'];

    public $with = ['user','post'];

    
    public function user(){

        return $this->belongsTo(User::class);
    }

    
    public function post(){

        return $this->belongsTo(Post::class);
    }

    // public function likedBy(User $user)
    // {
    //     return $this->likes->contains('user_id', $user->id);
    // }
}
