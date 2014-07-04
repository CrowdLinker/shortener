<?php namespace Crowdlinker\Repositories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use User,Account;
use League\Fractal;
class DbUserRepository implements UserInterface
{
    /**
     * Create new account
     * @param $data
     * @param $token
     * @param bool $socialmedia
     * @return mixed|void
     */
    public function create($data,$socialmedia = false,$token = NULL)
    {
        $user = new User;
        $user->firstname = !$socialmedia ? $data['firstname'] : $data['first_name'];
        $user->lastname = !$socialmedia ? $data['lastname'] : $data['last_name'];
        $user->email = $data['email'];
        $user->password =  !$socialmedia ? Hash::make($data['password']) : NULL;
        $user->save();
        if($socialmedia)
        {
            $this->addAccount($user,$data['id'],$token->getAccessToken(),$token->getEndOfLife(),'facebook',$data['email']);
        }
        return $user;
    }

    /**
     * Check if email exists. If exists link it to that account or
     * Create new account
     * @param $data
     * @return mixed|void
     */
    public function createTwitter($data)
    {
        $check = $this->checkUserTwitter($data['email']);
        if($check == "EXISTS")
        {
            $user = User::where('email','=',$data['email'])->first();
        }
        else
        {
            $user = new User;
            $user->firstname = $data['firstname'];
            $user->lastname = $data['lastname'];
            $user->email = $data['email'];
            $user->save();
        }
        $this->addAccount($user,$data['providerid'],$data['token'],$data['secret'],'NONE','twitter','NONE');
        Auth::login($user);
    }

    /**
     * Check for existing user email
     * @param $email
     * @return bool|mixed
     */
    public function checkUser($email)
    {
        $account = Account::where('primary_email','=',$email)->count();
        $user = User::where('email','=',$email)->count();

        if($user > 0 && $account == 0)
        {
            return 'ACCOUNT';
        }
        if($user == 0 && $account == 0)
        {
            return 'CREATE';
        }
        if($user == 0 && $account > 0 || $user > 0 && $account > 0 )
        {
            return 'EXISTS';
        }
    }

    /**
     * Check account for twitter
     * @param $email
     * @return string
     */
    private function checkUserTwitter($email)
    {
        $user = User::where('email','=',$email)->count();
        return ($user > 0) ? 'EXISTS' : 'CREATE';
    }

    /**
     * Set provider for facebook
     * @param $email
     * @param $provider_id
     * @param $token
     * @return mixed
     */
    public function setProviderFacebook($email,$provider_id,$token)
    {
        $user = User::with('accounts')->where('email','=',$email)->first();
        if(count($user['accounts']) == 0) $this->addAccount($user,$provider_id,$token->getAccessToken(),$token->getEndOfLife(),$email,'facebook');
        return $user;
    }


    /**
     * Set Account Password
     * @param $data
     * @return mixed
     */
    public function setPassword($data)
    {
        $userid = Auth::user()->id;
        $user = User::find($userid);
        $user->password = Hash::make($data);
        return $user->save();
    }

    /**
     * Set Email
     * @param $email
     * @return mixed|void
     */
    public function setEmail($email)
    {
        $userid = Auth::user()->id;
        $user = User::find($userid);
        $user->email = $email;
        $user->save();
    }

    /**
     * Check Account Password
     * @return bool|mixed
     */
    public function checkAccountPassword()
    {
        return (Auth::user()->password ==  NULL) ? true : false;
    }

    /**
     * Get User Id
     * @param $email
     * @return mixed
     */
    public function getUserid($email)
    {
       $account = Account::where('primary_email','=',$email)->first();
       $user = User::find($account['user_id']);
       return $user;
    }

    /**
     * @param $user
     * @param $id
     * @param $token
     * @param $secret
     * @param $endlife
     * @param $provider
     * @param $email
     */
    private function addAccount($user,$id,$token,$secret=null,$endlife,$provider,$email)
    {
        $account = new Account;
        $account->token = $token;
        $account->secret = !is_null($secret) ? $secret : null;
        $account->expiry = Carbon::createFromTimeStamp((int)$endlife)->diffInDays();
        $account->primary_email = $email;
        $account->provider = $provider;
        $account->providerid = $id;
        $account->user()->associate($user);
        $account->save();

    }

    /**
     * soft delete account / deactivate
     * @return mixed|void
     */
    public function delete()
    {
        $user = User::find(Auth::user()->id);
        $user->delete();
    }

    /**
     * Check if TwitterExists already
     * @param $twitterid
     * @return bool|mixed
     */
    public function checkTwitterExists($twitterid)
    {
        $count = Account::with('user')->where('providerid','=',$twitterid)->whereNotNull('user_id')->first();
        return count($count) > 0 ? $count['user']['id'] : false;
    }

    /**
     * Get List of social accounts
     * @param $id
     * @return mixed|void
     */
    public function getSocialAccounts($id)
    {
        $fractal = new Fractal\Manager();
        $accounts = Account::where('user_id','=',$id)->first();
        $resource = new Fractal\Resource\Collection($accounts,function(Account $value)
        {
            return [
                'provider' => $value->provider,
                'profileimage' => $value->profileimage
            ];
        });
        return $fractal->createData($resource)->toArray();
    }

    /**
     * Update facebook account token and info on login
     * @param $id
     * @param $token
     * @param $result
     * @return mixed|void
     */
    public function updateFBAccount($id,$token,$result)
    {
        $endlife = $token->getEndOfLife();
        $account = Account::where('user_id','=',$id)->where('provider','=','facebook')->first();
        $account->token = $token->getAccessToken();
        $account->expiry = Carbon::createFromTimeStamp((int)$endlife)->diffInDays();
        $account->profileimage ='https://graph.facebook.com/'.$result['id'].'/picture?width=140&height=140';
        $account->save();
    }

    /**
     * Update Twitter account on login.
     * @param $id
     * @param $token
     * @param $secret
     * @param $image
     */
    public function updateTwitterAccount($id,$token,$secret,$image)
    {
        $account = Account::where('user_id','=',$id)->where('token','=',$token)->first();
        $account->token = $token;
        $account->secret = $secret;
        $account->profileimage = $image;
        $account->save();
    }

}