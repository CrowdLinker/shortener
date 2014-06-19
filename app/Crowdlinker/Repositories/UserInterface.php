<?php namespace Crowdlinker\Repositories;

interface UserInterface
{
    /**
     * Create new user account
     * @param $data
     * @return mixed
     */
    public function create($data,$socialmedia = false);

    /**
     * Check if user already exists
     * @param $email
     * @return mixed
     */
    public function checkUser($email);

    /**
     * Set password if logged in using Social Media
     * @param $email
     * @return mixed
     */
    public function setPassword($email);

    /**
     * @param $email
     * @param $provider_id
     * @return mixed
     */
    public function setProviderFacebook($email,$provider_id);

}