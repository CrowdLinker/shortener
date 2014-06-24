<?php  namespace Crowdlinker\Shortener\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use ShortLink,Referrer,Location,LocationCity;
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
        $data = ShortLink::where('user_id','=',$id)->remember(10)->get();
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
        $check = $this->checkLocationExists($lon,$lat);
        if(!$check)
        {
            $this->insertLocation($shortlink,$city,$lat,$lon);
        }
        else
        {
            $location = Location::where('latitude','=',$lat)->where('longitude','=',$lon)->first();
            $this->addLocationCity($location->id,$city);
        }
    }

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

    /**
     * Insert Location Coordinates
     * @param $slink
     * @param $city
     * @param $lat
     * @param $lon
     */
    private function insertLocation($slink,$city,$lat,$lon)
    {
        $location = new Location;
        $location->latitude = $lat;
        $location->longitude = $lon;
        $location->shortlink()->associate($slink);
        $location->save();

        $location_city = new LocationCity;
        $location_city->city = $city;
        $location_city->location()->associate($location);
        $location_city->save();

    }

    /**
     * Add Location City name
     * @param $lid
     * @param $city
     */
    private function addLocationCity($lid,$city)
    {
        $location = new LocationCity;
        $location->city = $city;
        $location->location_id = $lid;
        $location->save();
    }

    /**
     * Check if Location already exists
     * @param $lon
     * @param $lat
     * @return bool
     */
    private function checkLocationExists($lon,$lat)
    {
        $location = Location::where('latitude','=',$lat)->where('longitude','=',$lon)->count();
        return $location > 0 ? true : false;
    }
}