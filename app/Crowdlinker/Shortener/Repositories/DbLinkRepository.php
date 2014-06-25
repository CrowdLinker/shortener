<?php  namespace Crowdlinker\Shortener\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use ShortLink,Referrer,Location,LinkView;
use Crowdlinker\GeoIP\geoipApi as GeoApi;
use Crowdlinker\SnowPlow\snowplowApi as SnowPlow;
class DbLinkRepository implements LinkRepositoryInterface
{
    /**
     * @param GeoApi $geoapi
     * @param SnowPlow $snowplow
     */
    public function __construct(GeoApi $geoapi,SnowPlow $snowplow)
    {
        $this->geoip = $geoapi;
        $this->snowplow = $snowplow;
    }

    /**
     * Get Short Links.
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return ShortLink::create($data);
    }

    /**
     * Short Link create Api
     * @param $url
     * @param $hash
     * @param $pagetitle
     * @param $provider
     * @param $uid
     * @return mixed|void
     */
    public function createApi($url,$hash,$pagetitle,$provider,$uid)
    {
        $shortlink = new ShortLink;
        $shortlink->url = $url;
        $shortlink->hash = $hash;
        $shortlink->pagetitle = $pagetitle;
        $shortlink->domainprovider = $provider;
        $shortlink->user_id = $uid;
        $shortlink->save();
    }

    /**
     * Get Link by Hash
     * @param $hash
     * @return mixed
     */
    public function byHash($hash)
    {
        return ShortLink::whereHash($hash)->first();
    }

    /**
     * Get Links by Url
     * @param $url
     * @return mixed
     */
    public function byUrl($url)
    {
        return ShortLink::whereUrl($url)->first();
    }

    /**
     * Get ShortLinks by User
     * @param $id
     * @return array|mixed
     */
    public function byUser($id)
    {
        $data = ShortLink::where('user_id','=',$id)->orderBy('created_at', 'DESC')->remember(10)->get();
        $links = [];
        foreach($data as $value)
        {
            $created_at = Carbon::createFromTimeStamp(strtotime($value->created_at));
            $links[] =
            [
                'id' => $value->id,
                'link' => 'http://'.$_ENV['SHORT_DOMAIN'].'/'.$value['hash'],
                'pagetitle' => $value->pagetitle,
                'provider' => $value->domainprovider,
                'clicks' => $value->clicks,
                'unique_clicks' => $value->unique_clicks,
                'created_at' => $created_at->toFormattedDateString()
            ];
        }
        return $links;
    }

    /**
     * Increase click count on view
     * @param $hash
     * @return mixed|void
     */
    public function increment($hash)
    {
        $shortlink = ShortLink::where('hash','=',$hash)->first();
        $shortlink->increment('clicks');
        $shortlink->save();
    }

    /**
     * Get Referrer Source
     * @param $hash
     * @param $referrer
     * @return mixed|void
     */
    public function referrer($hash,$referrer)
    {
        $shortlink = ShortLink::where('hash','=',$hash)->first();
        $source =  $this->snowplow->parse($referrer,$hash);
        $referrer = new Referrer;
        $referrer->source = is_null($source) ? "direct" : $source;
        $referrer->shortlink()->associate($shortlink);
        $referrer->save();
    }

    /**
     * Get Data from IP
     * @param $hash
     * @param $ip
     * @return mixed|void
     */
    public function location($hash,$ip)
    {
        $shortlink = ShortLink::where('hash','=',$hash)->first();
        $ip_compressed = md5($ip);
        $data = Cache::remember("geoip-{$ip_compressed}",1440,function() use ($ip)
        {
            return $this->geoip->fetchdata($ip);
        });
        $lon = $data['longitude'];
        $lat = $data['latitude'];
        $city = $data['city'];
        $country = $data['country_name'];
        $this->insertLocation($ip,$shortlink,$city,$country,$lat,$lon);
    }

    /**
     * Link Analytics
     * @param $data
     * @return array|mixed
     */
    public function linkDetails($data)
    {
        $details = $data->toArray();
        $sources = $this->referrerCount(array_fetch($details,'referrers'));
        list($source,$count) = array_divide($sources);
        $output =
        [
            'pagetitle' => $details[0]['pagetitle'],
            'original_url' => $details[0]['url'],
            'domain' => $details[0]['domainprovider'],
            'hash' => $details[0]['hash'],
            'totalclicks' => $details[0]['clicks'],
            'uniqueclicks' => $details[0]['unique_clicks'],
            'referrers' => $sources,
            'graph_data' =>
            [
                'source' => $source,
                'count' => $count,
            ]
        ];
        return $output;
    }

    private function referrerCount($data)
    {
        $count = [];
        foreach($data[0] as $value)
        {
            $count[] = $value['source'];
        }

        return array_count_values($count);
    }

    private function locationCount($data)
    {
        $count = [];
        foreach($data[0] as $value)
        {
            $count[] = $value['city'];
        }

        return array_count_values($count);
    }

    /**
     * Insert Location Coordinates
     * @param $ip
     * @param $slink
     * @param $city
     * @param $lat
     * @param $country
     * @param $lon
     */
    private function insertLocation($ip,$slink,$city,$country,$lat,$lon)
    {
        $location = new Location;
        $location->latitude = $lat;
        $location->longitude = $lon;
        $location->city = $city;
        $location->country = $country;
        $location->ip = $ip;
        $location->shortlink()->associate($slink);
        $location->save();
    }

    /**
     * Check if session cookie already exists.
     * @param $id
     * @return bool|mixed
     */
    public function checkSession($id)
    {
       $count = LinkView::where('session_id','=',$id)->count();
       return $count > 0 ? true : false;
    }

    /**
     * Create entry to mark that link is clicked/viewed.
     * @param $id
     * @param $sess_id
     * @return mixed|void
     */
    public function addViewed($id,$sess_id)
    {
        $shortlink = ShortLink::where('hash','=',$id)->first();
        $linkview = new LinkView;
        $linkview->shortlink_id = $shortlink->id;
        $linkview->session_id = $sess_id;
        $linkview->save();
    }
}