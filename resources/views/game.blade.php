@extends('layouts.app')

<script src="//static.miniclipcdn.com/js/game-embed.js"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="app">
                <game/>
            </div>
        </div>
    </div>
</div>
@endsection

