<?php

use Crowdlinker\Repositories\UserInterface as User;

class AuthController extends ApiController {

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     * GET /auth
     *
     * @return Response
     */
    public function index()
    {
        JavaScript::put(['url' => URL::to('/')]);
        return View::make('login');
    }

    /**
     * Register Account
     * @return mixed
     */
    public function register()
    {
        JavaScript::put(['url' => URL::to('/')]);
        return View::make('register');
    }

    /**
     * Create User Account
     * @return mixed
     */
    public function store()
    {
        $rules =
            [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|unique:user,email',
                'password' => 'required|confirmed|min:6'
            ];
        $messages =
            [
                'firstname.required' => 'First name is required',
                'lastname.required' => 'Last name is required',
                'email.required' => 'Email is required',
                'email.unique' => 'User is already registered.',
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
            $this->user->create(Input::all());
            return $this->setStatusCode(201)->respondWithSuccess('Successfully created account');
        }
    }


    /**
     * Authorize user with email and password
     * @return mixed
     */
    public function authorize()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $remember = Input::get('remember');
        if (Auth::attempt(['email' => $email, 'password' => $password],$remember == 'yes' ? true : false))
        {
            return $this->setStatusCode(200)->respondWithSuccess('Successfully Authorized!');
        }
        else
        {
            return $this->setStatusCode(400)->respondWithError('Username or password is incorrect');
        }
    }

    /**
     * Authorize user using Facebook Social Media
     * @return mixed
     */
    public function facebook()
    {
        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = OAuth::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );
            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );
            $checkemail = $this->user->checkUser($result['email']);
            //If user account's email is matching with Facebook account email and already exists
            //Add Facebook Token
            $user = ($checkemail) ? $this->user->setProviderFacebook($result['email'],$result['id'],$token) : $this->user->create($result,true,$token);
            //Get User Id and login
            Auth::loginUsingId((int)$user->id);
            $this->insertSession($result['id'],$token->getAccessToken(),'facebook');
            return Redirect::to('dashboard');
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }
    }

    /**
     * Insert Session
     * @param $id
     * @param $token
     * @param $provider
     */
    private function insertSession($id,$token,$provider)
    {
        $session =
            [
                'provider_name' => $provider,
                'provider_uid' => $id,
                'provider-token' => $token,
                'provider-profile-image' => 'https://graph.facebook.com/'.$id.'/picture?width=140&height=140'
            ];

        if(Session::has('user'))
        {
            Session::push('users',$session);
        }
        else
        {
            Session::put('users',$session);
        }
    }
}