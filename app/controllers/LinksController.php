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
        JavaScript::put(['url' => URL::to('/'),'csrf' => csrf_token() ]);
        $title = 'URL Shortener';
        return View::make('home',compact('title'));
    }

    public function shortdomainmain()
    {
        return View::make('shortdomain');
    }

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store()
    {
        try
        {
            $hash = Shortener::makeHome(Input::get('url'));
            return $this->setStatusCode(201)->respond($hash);
        }
        catch (ValidationException $e)
        {
            return $this->setStatusCode(400)->respondWithError($e);
        }
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
            return $this->setStatusCode(400)->respondWithError($e);
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
            return Redirect::to($url,301);
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
        $data = Shortener::getLinksbyUser(Auth::user()->id);
        return $this->setStatusCode(200)->respond($data);
    }
}