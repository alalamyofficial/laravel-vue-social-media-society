<?php

namespace App\Http\Controllers;

use App\Friendship;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Notifications\FriendShipNotifications;

class FriendshipController extends Controller
{

    public function addFriend($id){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $user = User::where('id',$id)->first();


        if(!$user){

            return redirect()->route('home')->with('info','user is not found');

        }

        if(Auth::user()->id === $user->id){

            return redirect()->back();

        }


        if(Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user()) )
        {

            return response()->json('Already Pending');

        }

        if(Auth::user()->isFriendsWith($user) || $user->hasFriendRequestPending(Auth::user()) )
        {
            return response()->json('Already Friends');

        }

        $add = Auth::user()->addFriend($user);


        $users = User::all();

        if($user->id !== Auth::user()->id){
            $user->notify(new FriendShipNotifications(Auth::user(),"Send Friend Request to you"));
        }


        return response()->json($add,200);

    }

    public function acceptFriend($id){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $user = User::where('id',$id)->first();

        
        if(!$user){

            return redirect()->route('home')->with('info','user is not found');

        }


        if(!Auth::user()->hasFriendRequestReceived($user)){

            return redirect()->route('home');

        }

        $accept = Auth::user()->acceptFriendRequest($user);

        return response()->json($accept,200);

    }

    public function deleteFriend($username){

        if(!\Request::ajax()){
            return redirect('/');
        }
        
        $user = User::where('username',$username)->first();

        if(Auth::user()->id == $user->id){
            
            return response()->json('You Can Not Remove Yourself',200);
            
        }
        
        $delete = Auth::user()->deleteFriends($user);
        
        return redirect()->back()->with('success','Friend Remove Successfully');
        

    }

    public function cancelRequest($id){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $user = User::where('id',$id)->first();

        $cancel = Auth::user()->cancelFriendRequest($user);
   
        return response()->json($cancel,200);

    }

    public function cancelAdd($id){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $user = User::where('id',$id)->first();

        $cancel = Auth::user()->cancelAddRequest($user);
   
        return response()->json($cancel,200);

    }

    public function check($id)
    {
        if(Auth::user()->is_friends_with($id) === 1)
        {
            return [ "status" => "friends" ];
        }
        
        if(Auth::user()->has_pending_friend_request_from($id))
        {
            return [ "status" => "pending" ];
        }

        if(Auth::user()->has_pending_friend_request_sent_to($id))
        {
            return [ "status" => "waiting" ];
        }

        return [ "status" => 0 ];
    }

    public function unreadNotifications()
    {
        $unreadNotifications = Auth::user()->unreadNotifications;
        return response()->json($unreadNotifications);
    }

    public function markAsRead()
    {

        Auth::user()->notifications->markAsRead();
        return response()->json('success');
    }

}
