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
Route::when('*', 'serviceCSRF', array('post','put'));
// Process Short Link Urls
Route::group(['domain' => $_ENV['SHORT_DOMAIN']],function()
{
    Route::get('/',['as' => 'home','uses' => 'LinksController@shortdomainmain']);
    Route::get('{hash}','LinksController@processHash')->after('clicks_shorturl|track_referrer|track_location');
});


//Front end
Route::get('/',['as' => 'home','before' => 'loggedin','uses' => 'LinksController@index']);
Route::get('/login',['as' => 'login','before' => 'loggedin','uses' => 'AuthController@index']);
Route::get('/register',['as' => 'register', 'uses' => 'AuthController@register']);
Route::controller('password', 'RemindersController');
Route::get('social/facebook',['as' => 'facebook','uses' => 'AuthController@facebook']);
Route::get('social/twitter',['as' => 'twitter','uses' => 'AuthController@twitter']);
Route::get('/logout',function()
{
    Auth::logout();
    Session::forget('users');
    Cache::flush();
    return Redirect::to('/');
});


//Dashboard
Route::get('dashboard',['as' => 'dashboard','before' => 'guest','uses' => 'DashboardController@index']);
Route::get('dashboard/settings',['as' => 'dashboardsettings','before' => 'guest','uses' => 'SettingsController@index']);
Route::get('dashboard/{id}',['as' => 'dashboard','before' => 'guest','uses' => 'AnalyticsController@index']);
Route::group(['prefix' => 'api'],function()
{
    Route::get('links',['as' => 'api.urls','before' => 'auth.basic','uses' => 'LinksController@getlinks']);
    Route::get('/links/detail/{shortlink}',['as' => 'api.url.detail','uses' => 'AnalyticsController@detail']);
    Route::get('/links/map/{shortlink}',['as' => 'api.url.map','before' => 'auth|checkuser','uses' => 'AnalyticsController@map']);
    Route::get('/links/location/{shortlink}',['as' => 'api.url.location','before' => 'auth|checkuser','uses' => 'AnalyticsController@location']);
    Route::post('create',['as' => 'api.create','uses' => 'LinksController@create']);
    Route::post('/home/create',['as' => 'api.home.create','uses' => 'LinksController@store']);
    Route::post('/user/create',['as' => 'api.createaccount', 'uses' => 'AuthController@store']);
    Route::post('/user/authorize',['as' => 'api.authorize', 'uses' => 'AuthController@authorize']);
    Route::put('/user/email/update',['as' => 'api.updateemail','before' => 'auth','uses' => 'SettingsController@setEmail']);
    Route::get('/user/password/exists',['as' => 'api.checkpass','before' => 'auth','uses' => 'SettingsController@checkpassword']);
    Route::put('/user/password/create',['as' => 'api.createpassword','before' => 'auth','uses' => 'SettingsController@setPassword']);
    Route::put('/user/password/change',['as' => 'api.changepassword','before' => 'auth','uses' => 'SettingsController@setPassword']);
    Route::get('/user/email',['as' => 'api.getuseremail','before' => 'auth','uses' => 'SettingsController@getemail']);
    Route::delete('/user/deactivate',['as' => 'api.deleteaccount','before' => 'auth','uses' => 'SettingsController@deleteaccount']);
});
Route::get('{slug}',['as' => 'globalanalytics','uses' => 'AnalyticsController@globalanalytics']);