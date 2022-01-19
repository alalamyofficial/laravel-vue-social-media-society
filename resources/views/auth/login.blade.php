<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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
<body>


<!-- component -->
<!-- Root element for center items -->
<div class="flex flex-col h-screen bg-gray-100">
    <!-- Auth Card Container -->
    <div class="grid place-items-center mx-2 my-20 sm:my-auto">
        <!-- Auth Card -->
        <div class="w-11/12 p-12 sm:w-8/12 md:w-6/12 lg:w-5/12 2xl:w-4/12 
            px-6 py-10 sm:px-10 sm:py-6 
            bg-white rounded-lg shadow-md lg:shadow-lg">

            <!-- Card Title -->
            <h2 class="text-center font-semibold text-3xl lg:text-4xl text-gray-800">
                Login to Our Society
            </h2>

            @include('validate')

            <form class="mt-10" method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Input -->
                <label for="email" class="block text-xs font-semibold text-gray-600 uppercase">E-mail</label>
                
                <div>
                    <input id="email" type="email" name="email" placeholder="e-mail address" 
                            value="{{ old('email') }}"  autocomplete="email" autofocus                    
                    class="block w-full py-3 px-1 mt-2 
                        text-gray-800 appearance-none 
                        border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200"
                        @error('email') is-invalid @enderror
                        required />

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div>
                    <!-- Password Input -->
                    <label for="password" class="block mt-2 text-xs font-semibold text-gray-600 uppercase">Password</label>
                    <input id="password" type="password" name="password" placeholder="password" 
                    autocomplete="current-password"
                        class="block w-full py-3 px-1 mt-2 mb-4
                        text-gray-800 appearance-none 
                        border-b-2 border-gray-100
                        focus:text-gray-500 focus:outline-none focus:border-gray-200"
                        @error('password') is-invalid @enderror
                        required />

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                
                </div>

                <!-- Auth Buttton -->
                <button type="submit"
                    class="w-full py-3 mt-10 bg-gray-800 rounded-sm mb-3
                    font-medium text-white uppercase
                    focus:outline-none hover:bg-gray-700 hover:shadow-none font-bold ">
                    Login
                </button>

                <center>or</center><br>

                <center>
                    <a  href="{{route('login.google')}}" 
                        class="bg-red-600 hover:bg-red-500 p-2 text-white mb-3 px-5 py-3 rounded-sm 
                        font-bold w-full">
                        Login With Google
                    </a>
                </center>
                    

                <!-- Another Auth Routes -->
                <div class="sm:flex sm:flex-wrap mt-8 sm:mb-4 text-sm text-center">
                    <a href="forgot-password" class="flex-2 underline">
                        Forgot password?
                    </a>

                    <p class="flex-1 text-gray-500 text-md mx-4 my-1 sm:my-auto">
                        or
                    </p>
        
                    <a href="register" class="flex-2 underline">
                        Create an Account
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>