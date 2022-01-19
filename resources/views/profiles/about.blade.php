@extends('profiles.app')

@section('content')


<about :users="{{$users}}" :profiles="{{$profiles}}" :user_id="{{Auth::id()}}"></about>

@endsection
