<?php namespace Crowdlinker\Repositories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        $user->email = $data['email'];
        $user->password =  !$socialmedia ? Hash::make($data['password']) : NULL;
        $user->save();
        if($socialmedia)
        {
            $this->addAccount($user,$data['id'],$token->getAccessToken(),$token->getEndOfLife(),$data['email']);
        }
        return $user;
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
        if($user == 0 && $account > 0 || $user > 0 && $account > 0)
        {
            return 'EXISTS';
        }
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
        if(count($user['accounts']) == 0) $this->addAccount($user,$provider_id,$token->getAccessToken(),$token->getEndOfLife(),$email);
        return $user;
    }


    public function setPassword($data)
    {
        $userid = Auth::user()->id;
        $user = User::find($userid);
        $user->password = Hash::make($data);
        return $user->save();
    }

    public function setEmail($email)
    {
        $userid = Auth::user()->id;
        $user = User::find($userid);
        $user->email = $email;
        $user->save();
    }

    public function checkAccountPassword()
    {
        if(Auth::user()->password == NULL)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

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
     * @param $endlife
     * @param $email
     */
    private function addAccount($user,$id,$token,$endlife,$email)
    {
        $account = new Account;
        $account->token = $token;
        $account->expiry = Carbon::createFromTimeStamp((int)$endlife)->diffInDays();
        $account->primary_email = $email;
        $account->provider = 'facebook';
        $account->facebook_id = $id;
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


}