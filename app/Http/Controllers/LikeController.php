<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use App\Post;
use Auth;

class LikeController extends Controller
{

    public function like(Request $request,$id){

        set_time_limit(0);

        if(!\Request::ajax()){
            return redirect('/');
        }

        $post = Post::find($id);

        $likecheck = like::where(['user_id'=>Auth::id(),'post_id'=>$request->id],'liked'== 1)->first();

    	if ($likecheck) {
    		like::where(['user_id'=>Auth::id(),'post_id'=>$request->id])->delete();
    		return 'deleted';
    	}else{

        $like =  Like::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'liked' => 1
        ]); 

        }
        return $like;

    }


}
