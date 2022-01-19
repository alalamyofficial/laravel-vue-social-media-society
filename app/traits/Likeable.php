<?php


namespace App\Traits;
use App\User;
use App\Post;

trait Likeable
{

    public function hasLikedStatus(Post $post){

        return (bool) $post->likes->where('user_id',$this->id)->count();

    }

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
    
}
