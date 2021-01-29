<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SPA Routes
|--------------------------------------------------------------------------
|
| Here is where you can register SPA routes for your frontend. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "spa" middleware group.
|
*/

Route::get('{path}', 'SpaController')->where('path', '(.*)');

Route::post('sociallogin/{provider}', 'Auth\SocialController@SocialSignup');
Route::get('auth/{provider}/callback', 'Auth\OutController@index')->where('provider', '.*');