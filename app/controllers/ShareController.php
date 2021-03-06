<?php

class ShareController extends ApiController {

	/**
	 * Show the form for creating a new resource.
	 * GET /share/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /share
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /share/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $title = 'Share';
        JavaScript::put(['url' => URL::to('/'),'csrf' => csrf_token(),'link' => 'http://'.$_ENV['SHORT_DOMAIN'].'/'.$id->hash,'message' => $id->pagetitle.' - '.'http://'.$_ENV['SHORT_DOMAIN'].'/'.$id->hash]);
		return View::make('share',compact('title'));
	}

    public function share()
    {
        $data = Input::all();
        if(count($data['socialaccounts']) == 0)
        {
            return $this->setStatusCode(400)->respondWithError('Please select social account');
        }
        try
        {
            Shortener::share($data);
            return $this->setStatusCode(200)->respondWithSuccess('Succesfully shared to social network accounts.');
        }
        catch(Exception $e)
        {
            Log::error($e);
            return $this->setStatusCode(400)->respondWithError('Oops Something is wrong');
        }
    }

}