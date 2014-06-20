<?php namespace Crowdlinker\Shortener;

use Crowdlinker\Shortener\Repositories\LinkRepositoryInterface as LinkRepo;
use Crowdlinker\Shortener\Utilities\UrlHasher;
use Crowdlinker\Shortener\Exceptions\NonExistentHashException;
use Crowdlinker\Embedly\EmbedlyApi as Embedly;
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
        $user_id = (Session::has('user_data')) ? Session::get('user_data')['userid'] : NULL;
        $this->linkRepo->createApi($url,$hash,$pagetitle,$domainprovider,$user_id);
        return $hash;
    }

    /**
     * Create Shortlink hash from Crowdlinker Dashboard
     * @param $url
     * @param $domainprovider
     * @param $pagetitle
     * @return string
     */
    private function makeHashFromApp($url,$domainprovider,$pagetitle)
    {
        $hash = $this->urlHasher->make($url);
        $user_id = (Session::has('user_data')) ? Session::get('user_data')['userid'] : NULL;
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
}