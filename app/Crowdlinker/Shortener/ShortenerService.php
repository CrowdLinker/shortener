<?php namespace Crowdlinker\Shortener;

use Crowdlinker\Shortener\Repositories\LinkRepositoryInterface as LinkRepo;
use Crowdlinker\Shortener\Utilities\UrlHasher;
use Crowdlinker\Shortener\Exceptions\NonExistentHashException;
use Crowdlinker\Embedly\EmbedlyApi as Embedly;
use Guzzle\Service\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ShortenerService
{
    protected $linkRepo;
    protected $urlHasher;

    public function __construct(LinkRepo $linkRepo,UrlHasher $urlHasher,Embedly $embedly)
    {
        $this->linkRepo = $linkRepo;
        $this->urlHasher = $urlHasher;
        $this->embedly = $embedly;
    }

    public function make($url)
    {
        return $this->makeHash($url);
    }

    public function makeHome($url)
    {
        $link = $this->linkRepo->byUrl($url);
        if($link)
        {
            return $link;
        }
        else
        {
            $hash = $this->makeHash($url);
            return $this->linkRepo->createHash($hash);
        }
    }

    /**
     * @param $hash
     * @return mixed
     * @throws NonExistentHashException
     */
    public function getUrlByHash($hash)
    {
        $link = $this->linkRepo->byHash($hash);
        if ( ! $link) throw new NonExistentHashException;
        return $link->url;
    }

    /**
     * Get All Short Links for specific user.
     * @param $id
     * @return mixed
     */
    public function getLinksbyUser($id)
    {
        return $this->linkRepo->byUser($id);
    }

    /**
     * Prepare Hash
     * @param $url
     * @return string
     * @throws \Guzzle\Service\Exception\ValidationException
     */
    private function makeHash($url)
    {
        $hash = $this->urlHasher->make($url);
        $url_compressed = md5($url);
        $page_data = Cache::remember("embedlink-{$url_compressed}",1440,function() use ($url)
        {
            return $this->embedly->fetchdata($url);
        });
        $domainprovider = $page_data['provider_display'];
        $pagetitle = is_null($page_data['title']) ? $url : $page_data['title'];
        $safe = $page_data['safe'];
        $favicon = is_null($page_data['favicon_url']) ? NULL : $page_data['favicon_url'];
        $user_id = (Auth::check()) ? Auth::user()->id : NULL;
        if($safe)
        {
            $this->linkRepo->createApi($url,$hash,$pagetitle,$domainprovider,$user_id,$favicon);
            return $hash;
        }
        else
        {
            throw new ValidationException($page_data['safe_message']);
        }
    }
    /**
     * Increment Click
     * @param $slug
     */
    public function incrementClick($slug)
    {
        $this->linkRepo->increment($slug);
    }

    /**
     * Track Referrer Source
     * @param $slug
     * @param $referrer
     */
    public function trackReferrer($slug,$referrer)
    {
        $this->linkRepo->referrer($slug,$referrer);
    }

    /**
     * Track Location of Client by Client IP Address
     * @param $slug
     * @param $ip
     */
    public function trackLocation($slug,$ip)
    {
        $this->linkRepo->location($slug,$ip);
    }

    /**
     * Check if session id already exists.
     * @param $sess_id
     * @param $slinkid
     * @return mixed
     */
    public function checkSessionExists($sess_id,$slinkid)
    {
        $check = $this->linkRepo->checkSession($sess_id,$slinkid);
        return $check;
    }

    /**
     * Log Unique Views.
     * @param $link_id
     * @param $sess_id
     */
    public function logUniqueView($link_id,$sess_id)
    {
        $this->linkRepo->addViewed($link_id,$sess_id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function linkDetails($data)
    {
        return $this->linkRepo->linkDetails($data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function locationDetails($data)
    {
        return $this->linkRepo->getLocation($data);
    }

    /**
     * @param $data
     * @param $shortlink
     * @return mixed
     */
    public function mapLocation($data,$shortlink)
    {
        return $this->linkRepo->getMapData($data,$shortlink);
    }
}