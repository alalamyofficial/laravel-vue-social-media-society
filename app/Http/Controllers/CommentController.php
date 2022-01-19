<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use Auth;

class CommentController extends Controller
{

    public function addComment(Request $request , $post){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post,
            'comment' => $request->comment
        ]);

        return $comment;

    }


    public function getComments(Post $post)
    {
        $comments_count = Comment::where('post_id',$post->id)->count();
        return response()->json($post->comments()->with('user')->latest()->get());
    }


    public function commentsCount($id){

        $comments_count = Comment::where('post_id',$id)->count();
        return response()->json($comments_count);

    }


    public function editComment(Request $request,$id){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $comment = Comment::find($id);
        return response()->json($comment,200);


    }


    public function updateComment(Request $request){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $comment = Comment::find($request->id);

        $comment->comment = $request->comment;
        $comment->update();
        return response()->json('Comment Updated Successfully',200);


    }


    public function deleteComment(Post $post,$id)
    {
        if(!\Request::ajax()){
            return redirect('/');
        }

        $comment = Comment::find($id);
        $comment->destroy($id);
        return response()->json("Comment is deleted",200);
    }


}
