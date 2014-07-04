<?php

use Crowdlinker\Repositories\UserInterface as User;
use Crowdlinker\Twitter\Manager;

class AuthController extends ApiController {

    protected $manager;
    public function __construct(User $user,Manager $manager)
    {
        $this->user = $user;
        $this->manager = $manager;
    }

    /**
     * Display a listing of the resource.
     * GET /auth
     *
     * @return Response
     */
    public function index()
    {
        $intended_url = Session::get('url.intended', URL::previous());
        JavaScript::put(['url' => URL::to('/'),'csrf' => csrf_token(),'redirect_intend' => $intended_url]);
        $title = 'URL Shortener - Login';
        return View::make('login',compact('title'));
    }

    /**
     * Register Account
     * @return mixed
     */
    public function register()
    {
        JavaScript::put(['url' => URL::to('/'),'csrf' => csrf_token()]);
        $title = 'URL Shortener - Register';
        return View::make('register',compact('title'));
    }

    public function start()
    {
        JavaScript::put(['url' => URL::to('/'),'csrf' => csrf_token()]);
        $title = "Let's Get Started";
        return View::make('twitteremail',compact('title'));
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


    public function storeTwitter()
    {
        $rules =
            [
                'email' => 'required|unique:user,email',
            ];
        $messages =
            [
                'email.required' => 'Email is required',
                'email.unique' => 'Email already exists.',
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
            list($firstname,$lastname) = explode(" ",Session::get('name'));
            $data =
                [
                   'email' => Input::get('email'),
                   'firstname' => $firstname,
                   'lastname' => $lastname,
                   'token' => Session::get('oauth_token'),
                   'secret' => Session::get('oauth_token_secret'),
                   'provider' => 'twitter',
                   'providerid' => Session::get('uid')
                ];
            $this->user->createTwitter($data);
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
        if($remember == "yes")
        {
            $remember_me = true;
        }
        else
        {
            $remember_me = false;
        }
        if (Auth::attempt(['email' => $email, 'password' => $password],$remember_me))
        {
            Session::forget('url.intended');
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
            switch($checkemail)
            {
                case 'ACCOUNT':
                    $user = $this->user->setProviderFacebook($result['email'],$result['id'],$token);
                    break;
                case 'EXISTS':
                    $user = $this->user->getUserid($result['email']);
                    break;
                case 'CREATE':
                    $user = $this->user->create($result,true,$token);
                    break;
            }
            //Get User Id and login
            Auth::login($user);
            $this->insertSession($result['id'],$token->getAccessToken(),'facebook');
            return Session::has('analytics.page') ? Redirect::to(Session::get('analytics.page'))->with('analytics.page','') : Redirect::to('dashboard');
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }
    }

    public function twitter()
    {
        try
        {
            $provider = $this->manager->get('twitter');
            $credentials = $provider->getTemporaryCredentials();
            Session::put('credentials',$credentials);
            Session::save();
            return $provider->authorize($credentials);
        }
        catch(Exception $e)
        {
            return App::abort(404);
        }
    }

    public function callback($provider)
    {
        try
        {
            $provider = $this->manager->get($provider);
            $token = $provider->getTokenCredentials(
                Session::get('credentials'),
                Input::get('oauth_token'),
                Input::get('oauth_verifier')
            );
            $user = $provider->getUserDetails($token);
            Session::put('username', $user->nickname);
            Session::put('name',$user->name);
            Session::put('uid',$user->uid);
            Session::put('oauth_token', $token->getIdentifier());
            Session::put('oauth_token_secret', $token->getSecret());
            Session::save();
            $check = $this->user->checkTwitterExists($user->uid);
            if($check)
            {
                   Auth::loginUsingId($check);
                   return Session::has('analytics.page') ? Redirect::to(Session::get('analytics.page'))->with('analytics.page','') : Redirect::to('dashboard');
            }
            else
            {
                return Redirect::to('start');
            }
        }
        catch(Exception $e)
        {
            dd($e);
            return App::abort(404);
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