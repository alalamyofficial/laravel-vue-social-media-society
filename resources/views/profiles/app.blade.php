<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="turbolinks-cache-control" content="no-preview">

    <link rel="stylesheet" href="{{asset('user/css/tailwind.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/tailwind.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/base.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/components.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/components.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/utilities.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/utilities.min.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/css/all.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

</head>
<body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
    <div class="w-full flex flex-row flex-wrap">
  <style>
  .round {
    border-radius: 50%;
  }
</style>

<div class="container-fluid">
    <div class="row justify-content-center" style="width:1465px">
        <div class="col-md-12">
            <div class="mt-7 pt-4 ml-0" style="left: -15px; position: relative;">
                @include('layouts.navbar')
            </div>
        </div>
    </div>
</div>            


<div id="app"  class="w-full bg-indigo-100 h-screen flex flex-row flex-wrap justify-center">
  
  <!-- Begin Navbar -->  

  
  <div class="bg-white shadow-lg border-t-4 border-indigo-500 absolute bottom-0 w-full md:w-0 md:hidden flex flex-row flex-wrap">
    <div class="w-full text-right"><button class="p-2 fa fa-bars text-4xl text-gray-600"></button></div>
  </div>
  
  @foreach($users as $user)
  <div class="w-0 md:w-1/4 lg:w-1/5 h-0 md:h-screen overflow-y-scroll bg-white shadow-lg pl-1">
    <div class="p-5 bg-white  top-0">
      <!-- <img class="border border-indigo-100 shadow-lg round" src="{{asset($user->avatar)}}"> -->

        <profile-pic :user="{{$user}}" :auth="{{Auth::user()}}"></profile-pic>

      <div class="pt-2 border-t mt-3 w-full text-center text-xl text-gray-600">
      
        <span class="ml-2">{{$user->name}}</span>
        
        @can('edit',$user)
          <a href="{{route('profile.about',$user->username)}}">
            <i class="fa fa-edit ml-2 fa-sm"></i>
          </a>
            <br>
        @endcan

      </div>


      @if(Auth::user()->id !== $user->id ) 
        <friendship :profile_user_id="{{$user->id}}"></friendship><br><br><br>
      @endif 



      <div class="mb-3 ml-4 mt-3">
          <strong>{{$user->profile->bio}}</strong>
      </div>


      <div class=" mt-3 pt-3 pb-3 pl-4 text-lg w-full"
      
      style="position: relative; margin-left: -61px; width:300px"

      >
      
        <div class="mb-1 bg-gray-100">
         @if($user->profile->location_from != Null) 
          <i class="fa fa-home mr-1"></i>
          <span class="mr-2">From</span> 
          <strong>{{$user->profile->location_from}}</strong>
         @endif 
        </div>

        <div class="mb-1 bg-gray-100">
        @if($user->profile->location_to != Null) 
        <i class="fa fa-home mr-1"></i>
          <span class="mr-2">Lives in</span> 
          <strong>{{$user->profile->location_to}}</strong>
        @endif  

        <div class="mb-1 bg-gray-100">
         @if($user->profile->status != Null) 
          <i class="fa fa-heart mr-1"></i>
          <span class="mr-1">I am</span> 
          <strong>{{$user->profile->status}}</strong>
         @endif 
        </div>

        </div>
        <div class="mb-1 bg-gray-100">
          <div>     
              @if(Cache::has('user-is-online-' . $user->id))
                <i class="fa fa-user mr-2"></i>Status <span class="text-success">Online</span>
              @else
                <i class="fa fa-user mr-2"></i>Status <span class="text-secondary">Offline</span>
              @endif
          </div>
          <div class="">
          
                <i class="fa fa-eye"></i> {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}
          
          </div>
        </div>
        <div class="mb-1 bg-gray-100">
        @if($user->profile->date_of_birth != Null) 
          <i class="fa fa-clock mr-1"></i> Date <span>{{$user->profile->date_of_birth}}</span>
        @endif  
        </div>

      </div>


    </div>
    <div class="w-full h-screen antialiased flex flex-col hover:cursor-pointer">
      <a class="hover:bg-gray-200 bg-gray-100 border-t-2 p-3 w-full text-xl text-left text-gray-600 font-semibold" href="{{route('profile',$user->username)}}"><i class="fa fa-book text-gray-600 text-2xl pr-1 pt-1 float-right"></i>Timeline</a>
      <a class="hover:bg-gray-200 bg-gray-100 border-t-2 p-3 w-full text-xl text-left text-gray-600 font-semibold" href="{{route('media',$user->username)}}"><i class="fa fa-image text-gray-600 text-2xl pr-1 pt-1 float-right"></i>Media</a>
      <a class="hover:bg-gray-200 bg-gray-100 border-t-2 p-3 w-full text-xl text-left text-gray-600 font-semibold" href="{{route('friends',$user->username)}}"><i class="fa fa-users text-gray-600 text-2xl pr-1 pt-1 float-right"></i>Friends</a>
      
      @can('edit',$user)
      <a class="hover:bg-gray-200 bg-gray-100 border-t-2 p-3 w-full text-xl text-left text-gray-600 font-semibold" href="{{route('chat')}}"><i class="fa fa-comment text-gray-600 text-2xl pr-1 pt-1 float-right"></i>Messages</a>
      <a class="hover:bg-gray-200 bg-gray-100 border-t-2 p-3 w-full text-xl text-left 
           text-gray-600 font-semibold" href="{{route('user.settings',$user->username)}}">

        <i class="fa fa-cog text-gray-600 text-2xl pr-1 pt-1 float-right"></i>Settings
      </a>
 
      @endcan
    </div>
  </div>
  @endforeach

  <!-- End Navbar -->
  
  <div class="w-full md:w-3/4 lg:w-4/5 p-5 md:px-12 lg:24 h-full overflow-x-scroll antialiased">

  @yield('content')    

  </div>
</div>


</div>

</body>
</html>
