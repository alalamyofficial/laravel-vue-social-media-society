<?PHP
header('Access-Control-Allow-Origin: *');
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @auth
                <feed   
                    :user_id="{{Auth::id()}}"
                    :post="{{ $post }}"
                ></feed>
            @endauth
            

        </div>
    </div>
</div>
@endsection
