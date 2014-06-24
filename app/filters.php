<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic('email');
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
    dd(Auth::check());
	if (!Auth::check()) return Redirect::to('/');
});

Route::filter('loggedin',function()
{
    if(Auth::check())
    {
        return Redirect::intended('dashboard');
    }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


Route::filter('clicks_shorturl',function()
{
    \Crowdlinker\Shortener\Facades\Shortener::incrementClick(Request::segment(1));
});

Route::filter('track_referrer',function()
{
    if(URL::previous() == URL::to('/dashboard'))
    {
        $referrer = 'direct';
    }
    else
    {
        $referrer = Request::server('HTTP_REFERER');
    }
        Shortener::trackReferrer(Request::segment(1),$referrer);
});

Route::filter('track_location',function()
{
    $request = Request::instance();
    $request->setTrustedProxies(array('127.0.0.1'));
    $ip = $request->getClientIp();
    Shortener::trackLocation(Request::segment(1),$ip);
});
