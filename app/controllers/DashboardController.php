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
		return View::make('dashboard');
	}

    /**
     * Shortlink detail analytics page
     * @return mixed
     */
    public function analytics()
    {
        JavaScript::put(['url' => URL::to('/')]);
        return View::make('detail');
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