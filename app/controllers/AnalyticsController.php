<?php

class AnalyticsController extends ApiController {

    /**
     * Analytics detail page
     * @param $id
     * @return mixed
     */
    public function index($id)
    {
        $getuserid = ShortLink::where('id','=',$id)->remember(10)->get();
        if(count($getuserid) > 0 && $getuserid[0]['user_id'] == Auth::user()->id)
        {
            JavaScript::put(['url' => URL::to('/'),'id' => $id ]);
            $title = 'Analytics';
            return View::make('detail',compact('title'));
        }
        else
        {
            App::abort(404);
        }

    }

    /**
     * Get Link Details
     * @param $shortlink
     * @return mixed
     */
    public function detail($shortlink)
    {

        $details = ShortLink::with('referrers')->where('id','=',$shortlink->id)->remember(10)->get();
        $data = Shortener::linkDetails($details);
        return $data;
        return $this->setStatusCode(200)->respond($data);

    }

    /**
     * @param $shortlink
     * @return mixed
     */
    public function location($shortlink)
    {
        $details = Location::where('shortlink_id','=',$shortlink->id)->remember(10)->get();
        $data = Shortener::locationDetails($details);
        return $this->setStatusCode(200)->respond($data);
    }
}