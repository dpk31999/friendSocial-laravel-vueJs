<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');
    Route::get('/show/{username}', 'Auth\UserController@show');

    Route::get('/posts/{username}','PostController@getByUsername');
    Route::resource('posts', 'PostController');
    
    Route::get('/friends/{user}', 'FriendController@getFriend');
    Route::get('/friends/request/{user}','FriendController@getRequest');
    Route::post('/friends/{id}','FriendController@updateStatusFriend');
    Route::get('/friends/status/{username}', 'FriendController@getStatusFriend');
    Route::get('/friends/count/{username}', 'FriendController@getCountFriend');

    Route::get('/posts/friend/{user}', 'PostController@getPostFriend');

    Route::get('/interests/people/{user}', 'InterestController@getPeople');
    Route::get('/interests','InterestController@index');
    Route::get('/interests/{user}', 'InterestController@showId');
    Route::get('/interests/name/{username}','InterestController@show');
    Route::put('/interests/{user}', 'InterestController@update');

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::post('settings/profile/avatar', 'Settings\ProfileController@updateAva');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::get('/messages/from/{username}','MessageController@getMessage');
    Route::post('/messages','MessageController@store');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
