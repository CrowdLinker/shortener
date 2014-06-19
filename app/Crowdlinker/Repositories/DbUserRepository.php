<?php namespace Crowdlinker\Repositories;
use Illuminate\Support\Facades\Hash;
use User;
class DbUserRepository implements UserInterface
{
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

    public function checkUser($email)
    {
        $user = User::where('email','=',$email)->count();
        return $user > 0 ? true : false;
    }

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