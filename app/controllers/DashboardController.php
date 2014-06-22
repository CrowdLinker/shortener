<?php

class DashboardController extends ApiController {

	/**
	 * Display a listing of the resource.
	 * GET /dashboard
	 *
	 * @return Response
	 */
	public function index()
	{
        JavaScript::put(['url' => URL::to('/')]);
        $title = 'Dashboard';
		return View::make('dashboard',compact('title'));
	}

    /**
     * Analytics Detail Page
     * @param $id
     * @return mixed
     */
    public function analytics($id)
    {
        JavaScript::put(['url' => URL::to('/'),'id' => $id ]);
        $title = 'Analytics';
        return View::make('detail',compact('title'));
    }

    public function settings()
    {
        JavaScript::put(['url' => URL::to('/')]);
        $title = 'Settings';
        return View::make('settings',compact('title'));
    }

    /**
     * Get Link Details
     * @param $shortlink
     * @return mixed
     */
    public function detail($shortlink)
    {
        if(Auth::check())
        {
            $details = ShortLink::with('referrers')->where('id','=',$shortlink->id)->remember(10)->get();
            $data = Shortener::linkDetails($details);
            return $this->setStatusCode(200)->respond($data);
        }
        else
        {
            return $this->setStatusCode(401)->respondWithError('Unauthorized Access');
        }
    }

}