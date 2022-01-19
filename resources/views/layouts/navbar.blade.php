<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm border border-gray-200">
    <div class="container">
        <a class="navbar-brand mr-5" href="/home">
            <div class="flex hover:bg-gray-100">
                <div>
                    <!-- <site-logo></site-logo> -->
                    <img src="{{asset('logo.png')}}" style="width:50px" alt="logo">

                </div>
                <div class="mt-1">
                    {{ config('app.name', 'Laravel') }}
                </div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mt-1" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @if(Auth::check())
                <ul class="navbar-nav mr-4">
                    <a href="{{route('profile',Auth::user()->username)}}">
                        <i class="fa fa-user-circle mr-1"></i>My Profile
                    </a>
                </ul>
            @endif

            <ul class="navbar-nav mr-4">
                <a href="{{route('game')}}">
                    <i class="fas fa-gamepad mr-1"></i>Games
                </a>
            </ul>   

            <ul class="navbar-nav mr-4">
                <a href="{{route('chat')}}">
                    <i class="fas fa-comments mr-1"></i>Chat
                </a>
            </ul>       

            <ul>
                <notifications></notifications>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>