<?php

class AnalyticsController extends ApiController {

    /**
     * Analytics detail page
     * @param $slug
     * @return mixed
     */
    public function index($slug)
    {
        $getuserid = ShortLink::where('hash','=',$slug)->remember(10)->get();
        if(count($getuserid) > 0 && $getuserid[0]['user_id'] == Auth::user()->id)
        {
            JavaScript::put(['url' => URL::to('/'),'id' => $getuserid[0]['id'], 'csrf' => csrf_token() ]);
            $title = 'Analytics';
            return View::make('detail',compact('title'));
        }
        else
        {
            App::abort(404);
        }

    }

   public function globalanalytics($slug)
   {
        Session::put('analytics.page',$slug);
        $getId = ShortLink::where('hash','=',$slug)->remember(10)->get();
        JavaScript::put(['url' => URL::to('/'),'id' => $getId[0]['id']]);
        $title = 'Analytics';
        if(Auth::check())
        {
            return View::make('detail',compact('title'));
        }
        return View::make('publicanalytics',compact('title'));
   }


    /**
     * Get Link Details
     * @param $shortlink
     * @return mixed
     */
    public function detail($shortlink)
    {

        $details = ShortLink::with('referrers')->where('id','=',$shortlink)->remember(10)->get();
        $data = Shortener::linkDetails($details);
        return $this->setStatusCode(200)->respond($data);

    }

    /**
     * Get data for top 5 cities and countries
     * @param $shortlink
     * @return mixed
     */
    public function location($shortlink)
    {

        $details = Location::where('shortlink_id','=',$shortlink)->remember(10)->get();
        $data = Shortener::locationDetails($details);
        return $this->setStatusCode(200)->respond($data);
    }

    /**
     * @param $shortlink
     * @return mixed
     */
    public function map($shortlink)
    {
        $details = Location::where('shortlink_id','=',$shortlink)->remember(10)->get(['latitude','longitude']);
        $data = Shortener::mapLocation($details,$shortlink);
        return $this->setStatusCode(200)->respond($data);
    }
}