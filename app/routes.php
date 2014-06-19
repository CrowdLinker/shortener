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

Route::get('/', function()
{
	return View::make('hello');
});
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
Route::group(['prefix' => 'api'],function()
{
    Route::post('/user/create',['as' => 'api.createaccount', 'uses' => 'AuthController@store']);
    Route::post('/user/authorize',['as' => 'api.authorize', 'uses' => 'AuthController@authorize']);
});
