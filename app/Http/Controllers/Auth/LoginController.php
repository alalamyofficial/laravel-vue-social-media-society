<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use Str;
use App\Profile;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function handleGoogleCallback()
    {

        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                 return redirect('/home');

            }else{

                $newUser = User::create([

                    'name' => $user->name,

                    'email' => $user->email,

                    // 'phone' => $user->phone,
                    
                    'username' => Str::slug($user->name),

                    // 'password' => Hash::make($user->password),
                    
                    // 'gender' => $user->gender,

                    'avatar' => 'https://www.pngrepo.com/png/221028/180/user-avatar.png',

                    'google_id'=> $user->id

                ]);

                Profile::create(['user_id' => $newUser->id ]);

                Auth::login($newUser);


                return redirect('/home');

            }

        } catch (Exception $e) {

            return redirect('login/google');

        }    

    }


    // Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }



        // Github login
        public function redirectToGithub()
        {
            return Socialite::driver('github')->redirect();
        }
    
        // Github callback
        public function handleGithubCallback()
        {
            $user = Socialite::driver('github')->user();
    
            $this->_registerOrLoginUser($user);
    
            // Return home after login
            return redirect()->route('home');
        }
    
        protected function _registerOrLoginUser($data)
        {
            $user = User::where('email', '=', $data->email)->first();
            if (!$user) {
                // $user = new User();
                // $user->name = $data->name;
                // $user->email = $data->email;
                // $user->phone = $data->phone;
                // $user->username = Str::slug($data['name']);
                // // $user->provider_id = $data->id; 
                // $user->avatar = $data->avatar;
                // $user->save();
                
                $user = User::create([
                    'name' => $data->name,
                    'email' => $data->email,
                    'password' => Hash::make($data->password),
                    'gender' => $data->gender,
                    'phone' => $data->phone,
                    'username' => Str::slug($data->name),
                    'avatar' => 'https://www.pngrepo.com/png/221028/180/user-avatar.png'
                ]);

            }
    
            Auth::login($user);
        }
}
