<?php namespace Crowdlinker\Repositories;

interface UserInterface
{
    /**
     * Create new user account
     * @param $data
     * @param bool $socialmedia
     * @param $token
     * @return mixed
     */
    public function create($data,$socialmedia = false,$token = NULL);

    /**
     * Check if user already exists
     * @param $email
     * @return mixed
     */
    public function checkUser($email);

    /**
     * Get User Id;
     * @param $email
     * @return mixed
     */
    public function getUserid($email);


    /**
     * Set Email if one doesn't exists or user signed in with Social Media
     * @param $email
     * @return mixed
     */
    public function setEmail($email);

    /**
     * Set password if logged in using Social Media
     * @param $data
     * @return mixed
     */
    public function setPassword($data);

    /**
     * Check whether user already has username and password.
     * @return mixed
     */
    public function checkAccountPassword();

    /**
     * @param $email
     * @param $provider_id
     * @param $token
     * @return mixed
     */
    public function setProviderFacebook($email,$provider_id,$token);

    /**
     * Soft Delete Account
     * @return mixed
     */
    public function delete();

    /**
     * Check if twitter exists
     * @param $name
     * @return mixed
     */
    public function checkTwitterExists($name);

    /**
     * Create new Twitter Account
     * @param $data
     * @return mixed
     */
    public function createTwitter($data);

    /**
     * Get All connected social accounts
     * @param $id
     * @return mixed
     */
    public function getSocialAccounts($id);

    /**
     * Update FB Account
     * @param $id
     * @param $token
     * @param $result
     * @return mixed
     */
    public function updateFBAccount($id,$token,$result);

    public function updateTwitterAccount($id,$token,$secret,$image);

}