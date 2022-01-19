<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/play', 'HomeController@games')->name('game');


Route::get('/profile/{username}', 'ProfileController@profile')->name('profile');
Route::get('/profile/{username}/about', 'ProfileController@about')->name('profile.about');
Route::put('/profile/update/{user_id}', 'ProfileController@update_profile')->name('profile.update');


//test
Route::get('friends',function(){

    return \App\User::find(1)->friends();

});   



//relationship
Route::get('/add/{id}','FriendshipController@addFriend');
Route::get('/accept/{id}','FriendshipController@acceptFriend')->name('accept');
Route::get('/delete/friend/{username}','FriendshipController@deleteFriend')->name('delete.friend');
Route::get('/cancel/{id}','FriendshipController@cancelRequest');
Route::get('/cancel/add/{id}','FriendshipController@cancelAdd');
Route::get('/check_relationship_status/{id}','FriendshipController@check');


//posts
Route::post('/save/posts','PostController@store')->name('save');
Route::get('/posts/{id}', 'PostController@show')->name('show');
Route::get('/feed', 'PostController@feed')->name('feed');
Route::get('/media/{username}', 'PostController@media')->name('media');
Route::get('/show/media/{id}', 'PostController@show_media')->name('show_media');
Route::delete('/post/delete/{id}', 'PostController@destroy')->name('post.destroy');

Route::get('/posts/images/{id}', 'PostController@showPostImage')->name('post.images');




Route::post('/imageUpload','PostController@uploadImage');

//friends
Route::get('/friends/{username}', 'ProfileController@friends')->name('friends');
Route::get('/friends/requests/{username}', 'ProfileController@friendsRequest')->name('friends.requests');
Route::get('/myfriends/{id}', 'ProfileController@myfriends')->name('myfriends');



//check
Route::get('/check_relationship_status/{id}','FriendshipController@check')->name('check');



//likes
Route::get('/like/{id}','LikeController@like')->name('post.like');



//Comment
Route::post('/comment/store/{post}', 'CommentController@addComment')->name('comment.store');
Route::get('/getComments/{post}', 'CommentController@getComments')->name('comment.show');
Route::delete('/comment/{id}', 'CommentController@deleteComment')->name('comment.destroy');
Route::get('/edit/comment/{id}', 'CommentController@editComment')->name('comment.edit');
Route::put('update/comment','CommentController@updateComment')->name('comment.update');
Route::get('comments/count/{id}','CommentController@commentsCount')->name('comment.count');


//user settings
Route::get('/settings/{username}','UserController@settings')->name('user.settings');
Route::post('/settings/update/{id}','UserController@update')->name('user.update');
Route::get('/suggest/friends','UserController@randomUser')->name('user.randomUser');
Route::post('update/user/image/{id}','UserController@changeAvatar')->name('user.avatar');

//Share
Route::get('/share','SocialShareController@share')->name('share');

//Social Login


// Google login
Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);


// // Facebook login
// Route::get('login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
// Route::get('login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback']);

// // Github login
// Route::get('login/github', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGithub'])->name('login.github');
// Route::get('login/github/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGithubCallback']);


//chat 

Route::get('/chat','MessageController@userList')->name('chat');
Route::get('/user/message/{id}', 'MessageController@user_message')->name('user.message');
Route::post('/sendMessage', 'MessageController@send_message')->name('user.message.send');
Route::get('/delete/message/{id}','MessageController@delete_message')->name('user.message.delete');


//notifications
Route::get('unreadNotifications', 'FriendshipController@unreadNotifications');
Route::get('markAsRead', 'FriendshipController@markAsRead');
