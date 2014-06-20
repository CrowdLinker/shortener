<?php

use Crowdlinker\Shortener\Exceptions\NonExistentHashException;
use Crowdlinker\Repositories\UserRepositoryInterface as User;

class LinksController extends \BaseController {

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
        Session::put('shortenerpage', str_random(40));
        return View::make('urlshortener.index');
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
        if(Session::has('user_data'))
        {
            try
            {
               return Shortener::make(Input::get('url'));
            }
            catch (ValidationException $e)
            {
                return Response::json([
                    'error' => $e->getErrors()
                ],500);
            }
        }
        else
        {
            return Response::json([
                'error' => ['API is secure. Need credentials.']
            ],401);
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
        if(Session::has('user_data'))
        {
            $data = Shortener::getLinksbyUser(Session::get('user_data')['userid']);
            return Response::json($data,200);
        }
        else
        {
            return Response::json([
                'error' => ['API is secure. Need credentials.']
            ],401);
        }
    }
}