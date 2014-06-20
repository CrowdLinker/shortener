<?php

use Crowdlinker\Shortener\Exceptions\NonExistentHashException;
use Crowdlinker\Repositories\UserInterface as User;

class LinksController extends ApiController {

    protected $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }



    /**
     * Home Page
     * @return mixed
     */
    public function index()
    {
        return View::make('home');
    }

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store()
    {
        try
        {
            $hash = Shortener::make(Input::get('url'));
        }
        catch (ValidationException $e)
        {
            return Redirect::home()->withErrors($e->getErrors())->withInput();
        }
        return Redirect::home()->with([
            'flash_message' => 'Here you go! ' . link_to($hash),
            'hashed'        => $hash
        ]);

    }


    /**
     * Create New Short Link (API)
     * @return mixed
     */
    public function create()
    {
        try
        {
            $hash = Shortener::make(Input::get('url'));
            return $this->setStatusCode(201)->respond(['hash' => $hash,'status_code' => 201]);
        }
        catch (ValidationException $e)
        {
            return $this->setStatusCode(400)->respondWithError('Oops! there was some problem');
        }
    }

    /**
     * Accept hash and fetch url
     * @param $hash
     * @return mixed
     */
    public function processHash($hash)
    {
        try
        {
            $url = Shortener::getUrlByHash($hash);
            return Redirect::to($url);
        }
        catch(NonExistentHashException $e)
        {
            return App::abort(404);
        }
    }

    /**
     * Get All created Short Links for User
     * @return mixed
     */
    public function getlinks()
    {
        if(Auth::check())
        {
            $data = Shortener::getLinksbyUser(Auth::user()->id);
            return $this->setStatusCode(200)->respond($data);
        }
        else
        {
            return $this->setStatusCode(401)->respondWithError('Unauthorized Access.');
        }
    }
}