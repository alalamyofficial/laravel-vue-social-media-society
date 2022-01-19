<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Friendable;

class Message extends Model
{
    use Friendable;

    public $with = ['user'];


    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'from');
    }
}
