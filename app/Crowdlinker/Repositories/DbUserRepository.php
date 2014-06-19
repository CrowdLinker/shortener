<?php namespace Crowdlinker\Repositories;
use Illuminate\Support\Facades\Hash;
use User;
class DbUserRepository implements UserInterface
{
    public function create($data)
    {
        $user = new User;
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->password =  Hash::make($data['password']);
        $user->save();
    }

    public function checkUser($email)
    {

    }

    public function setPassword($email)
    {

    }
}