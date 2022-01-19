<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        // $post = Post::where('user_id',$userId)->latest()->get();
        $post = auth()->user()->posts;

        $one_post = Post::first();



        $friends = User::where('id',$userId)->latest()->get();


        return view('home',compact('post','friends'));
    }

    public function games(){

        return view('game');

    }
}
