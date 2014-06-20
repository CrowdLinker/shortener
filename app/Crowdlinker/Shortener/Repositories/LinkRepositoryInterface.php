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

    /**
     * Track Referrer
     * @param $slug
     * @param $referrer
     * @return mixed
     */
    public function referrer($slug,$referrer);

    /**
     * Track Location
     * @param $slug
     * @param $ip
     * @return mixed
     */
    public function location($slug,$ip);

    /**
     * Get Details and Analytics Data
     * @param $data
     * @return mixed
     */
    public function linkDetails($data);
}