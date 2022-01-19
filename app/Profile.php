<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id','location_from','location_to','bio','status','date_of_birth'];


    public function user(){

        return $this->belongsTo(User::class);
    }

    public function posts(){

        return $this->hasMany(Post::class,'user_id');
    }
}
