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
    $sess_id = Session::getId();
    $check = Shortener::checkSessionExists($sess_id,Request::segment(1));
    if(Agent::isRobot() || Agent::match('Flipboard|flipboard') || Agent::match('Google') || Agent::match('Linkedin') || Agent::match('Bot|bot') || Agent::match('metauri.com') || Agent::match('help@dataminr.com') || Agent::match('Google-HTTP-Java-Client') || Agent::match('Trident') || Agent::match('http://www.facebook.com/externalhit_uatext.php') || Agent::platform() == "")
    {
        Log::error(Request::server('HTTP_USER_AGENT'));
    }
    else
    {
        Log::info(Request::server('HTTP_USER_AGENT'));
        \Crowdlinker\Shortener\Facades\Shortener::incrementClick(Request::segment(1));
        if(!$check)
        {
            Shortener::logUniqueView(Request::segment(1),$sess_id);
        }
    }
});

Route::filter('track_referrer',function()
{
    if(Agent::isRobot() || Agent::match('Flipboard|flipboard') || Agent::match('Google') || Agent::match('Linkedin') || Agent::match('Bot|bot') || Agent::match('metauri.com') || Agent::match('help@dataminr.com') || Agent::match('Google-HTTP-Java-Client') || Agent::match('Trident') || Agent::match('http://www.facebook.com/externalhit_uatext.php') || Agent::platform() == "")
    {
        Log::info(Request::server('HTTP_USER_AGENT'));
    }
    else
    {
        $referrer = Request::server('HTTP_REFERER');
        Shortener::trackReferrer(Request::segment(1),$referrer);
    }
});

Route::filter('track_location',function()
{
    if(Agent::isRobot() || Agent::match('Flipboard|flipboard') || Agent::match('Google') || Agent::match('Linkedin') || Agent::match('Bot|bot') || Agent::match('metauri.com') || Agent::match('help@dataminr.com') || Agent::match('Google-HTTP-Java-Client') || Agent::match('Trident') || Agent::match('http://www.facebook.com/externalhit_uatext.php') || Agent::platform() == "")
    {
        Log::info(Request::server('HTTP_USER_AGENT'));
    }
    else
    {
        $request = Request::instance();
        $request->setTrustedProxies(array('127.0.0.1'));
        $ip = $request->getClientIp();
        Shortener::trackLocation(Request::segment(1),$ip);
    }
});

Route::filter('checkuser',function()
{
    $id = Request::segment(4);
    if(Auth::check())
    {
        $count = ShortLink::where('id','=',$id)->where('user_id','=',Auth::user()->id)->count();
        if($count == 0)
        {
            return App::abort(404);
        }
    }
    else
    {

    }
});

Route::filter('serviceCSRF',function(){
    $aHeaders = getallheaders();
    if (Session::token() != $aHeaders['csrf_token']) {
        return Response::json([
            'message' => 'I’m a teapot !!! you stupid hacker :D '
        ], 418);
    }
});
