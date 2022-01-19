<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile($username)
    {
        $users = User::where('username',$username)->get();

        return view('profiles.profile',compact('users'));
    }

    public function friends($username){

        $users = User::where('username',$username)->get();

        $user = User::where('username',$username)->first();


        $friends = $user->friends();

        return view('profiles.friends',compact('username','users','friends','user'));

    }

    public function friendsRequest($username){

        $users = User::where('username',$username)->get();
        
        $user = User::where('username',$username)->first();

        $friends = Auth::user()->friendRequests();

        if(Auth::id() == $user->id){

            return view('profiles.friends_requests',compact('username','users','friends','user'));
        }else{
            abort(404);
        }


    }

    public function myfriends($id){

        if(!\Request::ajax()){
            return redirect('/');
        }

        $user = User::where('id',$id)->first();
        $users = $user->friends();
        return $users;

    }

    public function about($username){

        if(auth()->user()->username != $username){

            abort(404);
        }


        $users = User::where('username',$username)->get();

        $user_id = request()->user()->id;

        $profiles = Profile::where('user_id',$user_id)->get();

        return view('profiles.about',compact('users','profiles'));


    }


    public function update_profile(Request $request ,$user_id){

        if(!\Request::ajax()){
            return redirect('/');
        }
        
        $profile = Profile::find($user_id);


        if ($request->has('avatar')) {
            
            $image = $request->image;

            $new_image = time().$image->getClientOriginalName();

            $image->move('public/uploads',$new_image);

            $post->image = 'public/uploads'.$new_image;
            
            $update_profile = [
    
                "location_from" => $request['location_from'],
                "location_to" => $request['location_to'],
                "bio" => $request['bio'],
                "status" => $request['status'],
                "date_of_birth" => $request['date_of_birth'],
    
             
            ];
        }else{

            $update_profile = [
    
                "location_from" => $request['location_from'],
                "location_to" => $request['location_to'],
                "bio" => $request['bio'],
                "status" => $request['status'],
                "date_of_birth" => $request['date_of_birth'],
    
             
            ];
        }


        $profile->update($update_profile);

        return response()->json('Profile Updated Successfully',200);

    }
    
}
