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
            return $this->setStatusCode(200)->respondWithSuccess('Successfully created account');
        }
    }

    public function authorize($provider)
    {

    }

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

            $message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message. "<br/>";

            //Var_dump
            //display whole array().
            dd($result);

        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }
    }

}