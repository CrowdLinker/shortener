<?php  namespace Crowdlinker\Shortener\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use ShortLink,Referrer,Location,LocationCity;
use Crowdlinker\GeoIP\geoipApi as GeoApi;
use Crowdlinker\SnowPlow\snowplowApi as SnowPlow;
class DbLinkRepository implements LinkRepositoryInterface
{
    public function __construct(GeoApi $geoapi,SnowPlow $snowplow)
    {
        $this->geoip = $geoapi;
        $this->snowplow = $snowplow;
    }

    public function create(array $data)
    {
        return ShortLink::create($data);
    }

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

    public function byHash($hash)
    {
        return ShortLink::whereHash($hash)->first();
    }

    public function byUrl($url)
    {
        return ShortLink::whereUrl($url)->first();
    }

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
                'link' => 'http://crdln.kr/'.$value['hash'],
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

    public function referrer($hash,$referrer)
    {
        $shortlink = ShortLink::where('hash','=',$hash)->first();
        $source = !is_null($referrer) ? $this->snowplow->parse($referrer,$hash) : 'direct';
        $referrer = new Referrer;
        $referrer->source = $source;
        $referrer->shortlink()->associate($shortlink);
        $referrer->save();
    }

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

    private function addLocationCity($lid,$city)
    {
        $location = new LocationCity;
        $location->city = $city;
        $location->location_id = $lid;
        $location->save();
    }

    private function checkLocationExists($lon,$lat)
    {
        $location = Location::where('latitude','=',$lat)->where('longitude','=',$lon)->count();
        return $location > 0 ? true : false;
    }

}