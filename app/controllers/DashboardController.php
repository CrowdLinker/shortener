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

}