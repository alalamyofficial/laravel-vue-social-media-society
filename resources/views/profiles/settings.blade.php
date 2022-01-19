@extends('profiles.app')

@section('content')


<user-settings :users="{{$users}}"></user-settings>

@endsection
