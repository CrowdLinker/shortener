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
        JavaScript::put(['url' => URL::to('/'),'csrf' => csrf_token()]);
        $title = 'Settings';
        return View::make('settings',compact('title'));
    }

    /**
     * Get Logged in user's email
     * @return mixed
     */
    public function getemail()
    {
        return $this->setStatusCode(200)->respond(['email' => Auth::user()->email]);
    }

    public function deleteaccount()
    {
        $this->user->delete();
        return $this->setStatusCode(200)->respondWithSuccess('Successfully Deactivated');
    }

    /**
     * Check if Account has Password
     * @return mixed
     */
    public function checkpassword()
    {
        $check = $this->user->checkAccountPassword();
        return $check ? $this->setStatusCode(404)->respondWithError('Password for account does not exists') : $this->setStatusCode(200)->respondWithSuccess('Password for account exists');
    }

    /**
     * Set New Password
     * @return mixed
     */
    public function setPassword()
    {
        if(Input::has('currentpassword'))
        {
            $rules =
                [
                    'currentpassword' => 'passcheck',
                    'password' => 'required|confirmed|min:6'
                ];
        }
        else
        {
            $rules =
                [
                    'password' => 'required|confirmed|min:6'
                ];
        }

        $messages =
            [
                'currentpassword.passcheck' => 'Current password is invalid',
                'password.required' => 'Password is required',
                'password.min' => 'Password should be minimum 6 characters',
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
            $this->user->setPassword(Input::get('password'));
            return $this->setStatusCode(201)->respondWithSuccess('Password successfully updated');
        }
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


    public function getaccounts()
    {
        return $this->setStatusCode(200)->respond($this->user->getSocialAccounts(Auth::user()->id));
    }
}