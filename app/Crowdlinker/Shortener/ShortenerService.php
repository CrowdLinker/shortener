<?php namespace Crowdlinker\Shortener;

use Crowdlinker\Shortener\Repositories\LinkRepositoryInterface as LinkRepo;
use Crowdlinker\Shortener\Utilities\UrlHasher;
use Crowdlinker\Shortener\Exceptions\NonExistentHashException;
use Crowdlinker\Embedly\EmbedlyApi as Embedly;
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

    public function makeDashboard($data)
    {
        return $this->makeHashFromApp($data['url'],$data['provider'],$data['title']);
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
     * Prepare and save new url + hash
     *
     * @param $url
     * @returns string
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
        $pagetitle = $page_data['title'];
        $user_id = (Auth::check()) ? Auth::user()->id : NULL;
        $this->linkRepo->createApi($url,$hash,$pagetitle,$domainprovider,$user_id);
        return $hash;
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
     * @return mixed
     */
    public function checkSessionExists($sess_id)
    {
        $check = $this->linkRepo->checkSession($sess_id);
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
}