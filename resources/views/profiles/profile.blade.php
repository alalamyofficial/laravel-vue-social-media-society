@extends('profiles.app')

@section('content')


@foreach($users as $user)

    <profile-post :user_id="{{$user->id}}" :me="{{Auth::id()}}"></profile-post>
    
@endforeach    
    

@endsection
