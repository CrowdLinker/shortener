<?php namespace Crowdlinker\Shortener\Repositories;

interface LinkRepositoryInterface
{
    /**
     * Create new link
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Create link (API)
     * @param $url
     * @param $hash
     * @param $pagetitle
     * @param $provider
     * @param $uid
     * @return mixed
     */
    public function createApi($url,$hash,$pagetitle,$provider,$uid);

    /**
     * Fetch link by hash
     * @param $hash
     * @return mixed
     */
    public function byHash($hash);

    /**
     * Fetch link by url
     * @param $url
     * @return mixed
     */
    public function byUrl($url);

    /**
     * Fetch all shortlinks created by specific users.
     * @param $id
     * @return mixed
     */
    public function byUser($id);

    /**
     * Increment click field
     * @param $hash
     * @return mixed
     */
    public function increment($hash);
}