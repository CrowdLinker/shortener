<?php

class AnalyticsController extends ApiController {

    /**
     * Analytics detail page
     * @param $id
     * @return mixed
     */
    public function index($id)
    {
        JavaScript::put(['url' => URL::to('/'),'id' => $id ]);
        $title = 'Analytics';
        return View::make('detail',compact('title'));
    }

    /**
     * Get Link Details
     * @param $shortlink
     * @return mixed
     */
    public function detail($shortlink)
    {

        $details = ShortLink::with('referrers','locations')->where('id','=',$shortlink->id)->remember(10)->get();
        $data = Shortener::linkDetails($details);
        return $this->setStatusCode(200)->respond($data);

    }
}