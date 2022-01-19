<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Rule;
use Auth;
use Carbon\Carbon;
use Cache;
use App\Http\Middleware\Userstatus;

class UserController extends Controller
{
    public function settings(Request $request,$username){

        $users = User::where('username',$username)->get();

        
        if(auth()->user()->username != $username){

            abort(404);
        }

        // $this->authorize('edit',$username);

        return view('profiles.settings',compact('users'));


    }

    public function update(Request $request, User $user,$id){


        $user = User::findOrFail($id);

        $update_user =[

            "name" => $request['name'],
            "username" => $request['username'],
            "email" => $request['email'],
            "gender" => $request['gender'],
            "phone" => $request['phone'],
            "password" => bcrypt($request['password']),
         
        ];

        $user->update($update_user);

        return response()->json('User Updated Successfully',200);

    }

    public function userOnlineStatus()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id))
                echo $user->name . " is online. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
            else
                echo $user->name . " is offline. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
        }
    }

    public function randomUser(){

        if(!\Request::ajax()){
            return redirect('/');
        }
                
        $rand_users = User::inRandomOrder()->limit(3)->get();
        return response()->json($rand_users,200);

    }

    public function changeAvatar(Request $request,$id){

        if(!\Request::ajax()){
            return redirect('/');
        }
        

        $user= User::find($id);

        $img_file = $request->avatar;
    
        $new_avatar = time().$img_file->getClientOriginalName();

        $img_file->move('public/files/',$new_avatar);

        $user->avatar = 'public/files/'.$new_avatar;

        $update_profile_image =[

            "avatar" => 'public/files/'.$new_avatar,

        ];

        $user->update($update_profile_image);

        return response()->json('Avatar Uploaded Successfully',200);

    }
}
