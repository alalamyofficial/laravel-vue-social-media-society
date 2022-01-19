<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Share;

class SocialShareController extends Controller
{
    public function share(){

        Share::page('http://jorenvanhocht.be')->facebook()->twitter()->getRawLinks();    

    }
}
