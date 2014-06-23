<?php

use Crowdlinker\Repositories\UserInterface as User;

class SettingsController extends ApiController {

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     * GET /settings
     *
     * @return Response
     */
    public function index()
    {
        JavaScript::put(['url' => URL::to('/')]);
        $title = 'Settings';
        return View::make('settings',compact('title'));
    }

    public function getemail()
    {
        return $this->setStatusCode(200)->respond(['email' => Auth::user()->email]);
    }


    public function checkpassword()
    {
        $check = $this->user->checkAccountPassword();
        return $check ? $this->setStatusCode(404)->respondWithError('Password for account does not exists') : $this->setStatusCode(200)->respondWithSuccess('Password for account exists');
    }

    /**
     * Set Email Address
     * @return mixed
     */
    public function setEmail()
    {
        $rules =
            [
                'email' => 'required|unique:user,email',
            ];
        $messages =
            [
                'email.required' => 'Email is required',
                'email.unique' => 'User is already registered.',
            ];

        $validator = Validator::make(Input::all(),$rules,$messages);

        if($validator->fails())
        {
            $messages = $validator->messages();
            $error_messages = $messages->all(':message');
            return $this->setStatusCode(400)->respondWithError($error_messages);
        }
        else
        {
            $this->user->setEmail(Input::get('email'));
            return $this->setStatusCode(201)->respondWithSuccess('Successfully created account');
        }
    }
}