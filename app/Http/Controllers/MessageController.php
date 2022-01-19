<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Events\MessageSend;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function userList(){

        $users = Auth::user()->friends();
        $users_count = $users->count();
        $id = request()->user()->id;
        $one_user = User::where('id',$id)->first();
        $friends = User::latest()->get();

        return view('chat.chat',compact('users','users_count','one_user','friends'));
    }

    public function user_message($id=null){

        $user = User::findOrFail($id);

        $messages = Message::where(function($q) use ($id){
            $q->where('from',auth()->user()->id);
            $q->where('to',$id);
            $q->where('type',0);
        })->orWhere(function($q) use ($id){
            $q->where('from',$id);
            $q->where('to',auth()->user()->id);
            $q->where('type',1);
        })->with('user')->get(); 

        
        return response()->json([
            'messages'=>$messages,
            'user'=>$user,
        ]);

    }

    public function send_message(Request $request){
        if(!$request->ajax()){
            abort(404);
        }
       $messages = Message::create([
           'message'=>$request->message,
           'from'=>auth()->user()->id,
           'to'=>$request->user_id,
           'type'=>0
       ]);
       $messages = Message::create([
            'message'=>$request->message,
            'from'=>auth()->user()->id,
            'to'=>$request->user_id,
            'type'=>1
        ]);
        broadcast(new MessageSend($messages));
        return response()->json($messages,200);

    }

    public function delete_message($id=null){

        if(!\Request::ajax()){
            return  abort(404);
        }
        Message::findOrFail($id)->delete();
        return response()->json('deleted',200);
    }

}
