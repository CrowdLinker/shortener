<?php namespace Crowdlinker\Repositories;
use Illuminate\Support\Facades\Hash;
use User;
class DbUserRepository implements UserInterface
{
    /**
     * Create new account
     * @param $data
     * @param bool $socialmedia
     * @return mixed|void
     */
    public function create($data,$socialmedia = false)
    {
        $user = new User;
        $user->firstname = !$socialmedia ? $data['firstname'] : $data['first_name'];
        $user->lastname = !$socialmedia ? $data['lastname'] : $data['last_name'];
        $user->email = $data['email'];
        $user->password =  !$socialmedia ? Hash::make($data['password']) : Hash::make(str_random(6));
        if($socialmedia)
        {
            $user->provider = 'facebook';
            $user->provider_uid = $data['id'];
        }
        $user->save();
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
     * @return mixed
     */
    public function setProviderFacebook($email,$provider_id)
    {
        $user = User::where('email','=',$email)->first();
        $user->provider = 'facebook';
        $user->provider_uid = $provider_id;
        $user->save();
        return $user;
    }


    public function setPassword($email)
    {

    }
}