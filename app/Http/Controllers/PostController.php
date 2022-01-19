<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Traits\Likeable;
use DB;

class PostController extends Controller
{

    public function store(Request $request)
    {
        if(!\Request::ajax()){
            return redirect('/');
        }
        
        $this->validate($request,[

            'images' => 'sometimes',
            'body' => 'required',
            'status' => 'required'

        ]);

        if ($request->hasFile('images')) {
            
            $images = $request->images;

            $new_image = time().$images->getClientOriginalName();

            $images->move('public/files/',$new_image);

        
            $posts = new Post([

                'user_id' => Auth::id(),
                'body' => $request->input('body'),
                'status' => $request->input('status'),
                'images' => 'public/files/'.$new_image
    
            ]);

            $posts->save();
                
            return response()->json($posts,200);

    

        }else{

            $posts = new Post([

                'user_id' => Auth::id(),
                'body' => $request->input('body'),
                'status' => $request->input('status'),
    
            ]);

            
            $posts->save();
        }
        
        return response()->json("Post Created Successfully",200);
    }


    public function uploadImage(Request $request)
    {
        if(!\Request::ajax()){
            return redirect('/');
        }

        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('files'), $fileName);

        return response()->json(['file' => $fileName]);
    }

    public function show(Post $post ,Request $request ,$id)
    {

        if(!\Request::ajax()){
            return redirect('/');
        }

        $me = Auth::id();

        $user = User::where('id',$id)->first();


        if(Auth::user()->id === $user->id || Auth::user()->isFriendsWith($user)){
            
            $posts = Post::where('user_id', $id )->latest()->get();
            return $posts;
            
        }else{

            $posts = Post::where('user_id', $id )->where('status','=',0)->latest()->get();
            return $posts;

        }



    }

    public function media(Request $request,$username){


        $users = User::where('username',$username)->get();

        return view('profiles.media',compact('users'));

    }

    public function show_media(Request $request,$id){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $posts = Post::where('user_id', $id )->Where('images' , '!=' , NULL )->latest()->get();
        return $posts;

    }

    public function showPostImage($id){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $posts = Post::where('user_id', $id )->latest()->get();
        return $posts;

    }

    public function destroy(Post $post,$id)
    {
        if(!\Request::ajax()){
            return redirect('/');
        }

        $post = Post::find($id);
        $post->delete($id);

        return response()->json('Post has been Deleted',200);
    }

    public function feed()
    {
        $friends = Auth::user()->friends();

        $feed = array();

        foreach($friends as $friend):
                foreach($friend->posts as $post):
                    array_push($feed, $post);
                endforeach;
        endforeach;

        foreach(Auth::user()->posts as $post):
            array_push($feed, $post);
        endforeach;

        usort($feed, function($p1, $p2){
            return $p1->id < $p2->id;
        });

        return $feed;
    }
}
