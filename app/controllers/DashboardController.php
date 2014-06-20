<?php

class DashboardController extends \BaseController {

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

}