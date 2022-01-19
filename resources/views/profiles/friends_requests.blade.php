@extends('profiles.app')

@section('content')

@if(session()->has('message'))
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert">x</button>
        {{session()->get('message')}}
    </div>
@endif

<div class="row">
    <div class="justify-between">
        <div>
            <h2 class="mb-2">{{$user->name}} 's Friends Requests ({{count($friends)}})</h2>
        </div>
        <div>
            <a href="{{route('friends',$user->username)}}">Friends</a>
        </div>
    </div>
</div>

<hr class="mb-3">

@if(count($friends) > 0)
    @foreach($friends as $friend)
    <div>
        <ol>
            <div class="bg-white p-3 text-xl border shadow">
                <div class="flex justify-content-between">
                    <div class="ml-8 p-1">
                        <div class="flex">
                            <img src="{{asset($friend->avatar)}}"  alt="img" width="40px" />
                            <b>
                                <a href="{{route('profile',$friend->username)}}" class="ml-2">{{$friend->name}}</a>
                            </b>
                        </div>
                    </div>
                    <div>
                        <a href="{{route('accept',$friend->id)}}" class="bg-green-400 p-1 pr-2 pl-2 border shadow hover:bg-gray-100">
                            Accept
                        </a>
                    </div>
                </div>
            </div>
        </ol>
    </div>
    @endforeach
@else
    <b>You Haven't Friends Requests Yet</b>    
@endif


@endsection
