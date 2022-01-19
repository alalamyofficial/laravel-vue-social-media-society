<?php
namespace App\Traits;

use App\Friendship;
use App\User;

trait Friendable
{

    public function friendsOfmine(){

        return $this->belongsToMany('App\User','friendships','user_id','friend_id');

    }
    public function friendsOf(){

        return $this->belongsToMany('App\User','friendships','friend_id','user_id');

    }

    public function friends(){

        return $this->friendsOfmine()->wherePivot('status',true)
                ->get()
        ->merge($this->friendsOf()->wherePivot('status',true)
                ->get()
        );

    }

    public function friendRequests(){

        return $this->friendsOfmine()->wherePivot('status',false)->get();

    }

    public function friendRequestsPending(){


        return $this->friendsOf()->wherePivot('status',false)->get();

    }

    public function hasFriendRequestPending(User $user){

        return (bool) $this->friendRequestsPending()->where('id',$user->id)->count();

    }

    public function hasFriendRequestReceived(User $user){

        return (bool) $this->friendRequests()->where('id',$user->id)->count();

    }

    public function addFriend(User $user){

        return $this->friendsOf()->attach($user->id);

    }

    public function cancelFriendRequest(User $user){

        return $this->friendRequests()->where('id',$user->id)->first()->pivot->delete();
    
    }

    
    public function cancelAddRequest(User $user){

        return $this->friendRequestsPending()->where('id',$user->id)->first()->pivot->delete();
    
    }

    public function deleteFriends(User $user){

        $this->friendsOfmine()->detach($user->id);

    }


    public function acceptFriendRequest(User $user){

        return $this->friendRequests()->where('id',$user->id)->first()->pivot->update([

            'status' => true

        ]);

    }

    public function isFriendsWith(User $user){

        return (bool) $this->friends()->where('id',$user->id)->count();

    }

    

    //for status
    
    // ===============================================================
    
    
	public function friends_ids()
	{
		return collect($this->friends())->pluck('id')->toArray();
	}


	public function is_friends_with($user_id)
	{
		if(in_array($user_id, $this->friends_ids())) 
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
    
    //----------------------------------------------------------------------------------

	public function pending_friend_requests_sent_ids()
	{
		return collect($this->friendRequestsPending())->pluck('id')->toArray();
	}
    
    public function has_pending_friend_request_sent_to($user_id)
	{
		if(in_array($user_id, $this->pending_friend_requests_sent_ids()))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

    //=========================================================================================
    

    public function pending_friend_requests_ids()
	{
		return collect($this->friendRequests())->pluck('id')->toArray();
	}

	public function has_pending_friend_request_from($user_id)
	{
		if(in_array($user_id, $this->pending_friend_requests_ids()))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}


}