<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::model('shortlink', 'ShortLink');
Route::get('/',['as' => 'home','before' => 'loggedin','uses' => 'LinksController@index']);
Route::get('/login',['as' => 'login','before' => 'loggedin','uses' => 'AuthController@index']);
Route::get('/register',['as' => 'register', 'uses' => 'AuthController@register']);
Route::controller('password', 'RemindersController');
Route::get('social/facebook',['as' => 'facebook','uses' => 'AuthController@facebook']);
Route::get('social/twitter',['as' => 'twitter','uses' => 'AuthController@twitter']);
Route::get('/logout',function()
{
    Auth::logout();
    Session::flush();
    return Redirect::to('/');
});
Route::get('dashboard',['as' => 'dashboard','before' => 'auth','uses' => 'DashboardController@index']);
Route::get('dashboard/{id}',['as' => 'dashboard','before' => 'auth','uses' => 'DashboardController@analytics']);
Route::group(['prefix' => 'api'],function()
{
    Route::get('links',['as' => 'api.urls','uses' => 'LinksController@getlinks']);
    Route::get('/links/detail/{shortlink}',['as' => 'api.url.detail','uses' => 'LinksController@detail']);
    Route::post('create',['as' => 'api.create','uses' => 'LinksController@create']);
    Route::post('/user/create',['as' => 'api.createaccount', 'uses' => 'AuthController@store']);
    Route::post('/user/authorize',['as' => 'api.authorize', 'uses' => 'AuthController@authorize']);
});

Route::post('links', 'LinksController@store');

// Process Short Link Urls
Route::group(['domain' => 'shortlink.192.168.33.10.xip.io'],function()
{
    Route::get('{hash}','LinksController@processHash')->before('clicks_shorturl|track_referrer|track_location');
});
