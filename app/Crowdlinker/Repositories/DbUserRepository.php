<?php namespace Crowdlinker\Repositories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use User,Account;
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
        $user->email = !$socialmedia ? $data['email'] : NULL;
        $user->password =  !$socialmedia ? Hash::make($data['password']) : NULL;
        $user->save();
        if($socialmedia)
        {
            $this->addAccount($user,$data['id'],$token->getAccessToken(),$token->getEndOfLife());
        }
    }

    /**
     * Check for existing user email
     * @param $email
     * @return bool|mixed
     */
    public function checkUser($email)
    {
        $user = User::where('email','=',$email)->count();
        return $user > 0 ? true : false;
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
        $user = User::where('email','=',$email)->first();
        $count = Account::where('user_id','=',$user->id)->count();
        if($count == 0) $this->addAccount($user,$provider_id,$token->getAccessToken(),$token->getEndOfLife());
        return $user;
    }


    public function setPassword($email)
    {

    }

    /**
     * @param $user
     * @param $id
     * @param $token
     * @param $endlife
     */
    private function addAccount($user,$id,$token,$endlife)
    {
        $account = new Account;
        $account->token = $token;
        $account->expiry = Carbon::createFromTimeStamp((int)$endlife)->diffInDays();
        $account->provider = 'facebook';
        $account->facebook_id = $id;
        $account->user()->associate($user);
        $account->save();

    }
}