<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');  //give the route a name

Route::post('/signin', [
    'uses' => 'UserController@postSignin',
    'as' => 'signin',  //using 'as' also gives the route a name/alias
]);

Route::get('/signout', [
    'uses' => 'UserController@getSignout',
    'as' => 'signout',
    'middleware' => 'auth',
]);

Route::post('/signup', [
    'uses' => 'UserController@postSignup',
    'as' => 'signup',
]);

// see $routeMiddleware in kernel.php
//added middleware to protect the route so user can't use /dashboard in the browser
Route::get('/dashboard', [
    'uses' => 'PostController@getDashboard',
    'as' => 'dashboard',
    'middleware' => 'auth',
]);

Route::post('/createpost', [
    'uses' => 'PostController@postCreatePost',
    'as' => 'post.create',
    'middleware' => 'auth',
]);

Route::get('/deletepost/{post_id}', [
    'uses' => 'PostController@getDeletePost',
    'as' => 'post.delete',
    'middleware' => 'auth',
]);

//invoked via jquery ajax post
Route::post('/editpost', [
    'uses' => 'PostController@postEditPost',
    'as' => 'post.edit',
    'middleware' => 'auth',
]);

Route::get('/account', [
    'uses' => 'UserController@getAccount',
    'as' => 'account',
    'middleware' => 'auth',
]);

Route::post('/editaccount', [
    'uses' => 'UserController@postEditAccount',
    'as' => 'account.edit',
    'middleware' => 'auth',
]);

Route::get('/userimage/{filename}', [
    'uses' => 'UserController@getUserImage',
    'as' => 'account.image',
    'middleware' => 'auth',
]);
//-----------------
Route::post('/like', [
    'uses' => 'PostController@postLikePost',
    'as' => 'post.like',
    'middleware' => 'auth',
]);
