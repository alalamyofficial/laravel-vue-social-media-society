<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Friendable;
use App\Traits\Likeable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use Notifiable,Friendable,Likeable,HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','avatar','gender','username','google_id','image','images'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(){

        return $this->hasOne(Profile::class);

    }

    
    public function posts(){

        return $this->hasMany(Post::class,'user_id');

    }

    public function comments(){

        return $this->hasMany(Comment::class);
    }

    public function getAvatarAttribute($value){

        return asset($value ? : "user.png");

    }

    public function messages(){
        return $this->hasMany(Message::class,'from');
    }
}
