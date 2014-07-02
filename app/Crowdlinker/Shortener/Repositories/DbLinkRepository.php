<?php  namespace Crowdlinker\Shortener\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use ShortLink,Referrer,Location,LinkView;
use Crowdlinker\GeoIP\geoipApi as GeoApi;
use Crowdlinker\SnowPlow\snowplowApi as SnowPlow;
use League\Fractal;
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
     * @param $favicon
     * @return mixed|void
     */
    public function createApi($url,$hash,$pagetitle,$provider,$uid,$favicon)
    {
        $shortlink = new ShortLink;
        $shortlink->url = $url;
        $shortlink->hash = $hash;
        $shortlink->pagetitle = $pagetitle;
        $shortlink->domainprovider = $provider;
        $shortlink->user_id = $uid;
        $shortlink->favicon = $favicon;
        $shortlink->save();
    }

    /**
     * Get Link by Hash
     * @param $hash
     * @return mixed
     */
    public function byHash($hash)
    {
        $shortlink = ShortLink::whereHash($hash)->whereNULL('user_id')->remember(10)->first();
        return $shortlink;
    }

    /**
     * Get Link by Hash
     * @param $hash
     * @return mixed
     */
    public function createHash($hash)
    {
        $fractal = new Fractal\Manager();
        $shortlink = ShortLink::whereHash($hash)->whereNULL('user_id')->remember(10)->first();
        $resource = new Fractal\Resource\Item($shortlink, function(ShortLink $value) {
            return [
                'id'      => (int) $value->id,
                'pagetitle'   => $value->pagetitle,
                'favicon'    => $value->favicon,
                'domainprovider'   => $value->domainprovider,
                'totalclicks' => $value->clicks,
                'hash' => $value->hash,
                'url' => 'http://'.$_ENV['SHORT_DOMAIN'].'/'.$value->hash
            ];
        });
        return $fractal->createData($resource)->toArray();
    }


    /**
     * Get Links by Url
     * @param $url
     * @return mixed
     */
    public function byUrl($url)
    {
        $fractal = new Fractal\Manager();
        $shortlink = ShortLink::whereUrl($url)->whereNull('user_id')->remember(10)->first();
        if($shortlink)
        {
            $resource = new Fractal\Resource\Item($shortlink, function(ShortLink $value) {
                return [
                    'id'      => (int) $value->id,
                    'pagetitle'   => $value->pagetitle,
                    'favicon'    => $value->favicon,
                    'domainprovider'   => $value->domainprovider,
                    'totalclicks' => $value->clicks,
                    'hash' => $value->hash,
                    'url' => 'http://'.$_ENV['SHORT_DOMAIN'].'/'.$value->hash
                ];
            });
            return $fractal->createData($resource)->toArray();
        }
        else
        {
            return $shortlink;
        }
    }

    /**
     * Get ShortLinks by User
     * @param $id
     * @return array|mixed
     */
    public function byUser($id)
    {
        $fractal = new Fractal\Manager();
        $data = ShortLink::where('user_id','=',$id)->orderBy('created_at', 'DESC')->remember(10)->get();
        $resource = new Fractal\Resource\Collection($data,function(ShortLink $value)
        {
            return [
                'id' => $value->id,
                'link' => 'http://'.$_ENV['SHORT_DOMAIN'].'/'.$value->hash,
                'pagetitle' => $value->pagetitle,
                'favicon' => $value->favicon,
                'hash' => $value->hash,
                'provider' => $value->domainprovider,
                'clicks' => $value->clicks,
                'unique_clicks' => $value->unique_clicks,
                'created_at' => Carbon::createFromTimeStamp(strtotime($value->created_at))->toFormattedDateString()
            ];
        });
       return $fractal->createData($resource)->toArray();
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
        $graphdata = $this->graphData(array_fetch($details,'referrers'));
        list($source,$count) = array_divide($graphdata);
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
                        'count' => $count
                    ]
            ];
        return $output;
    }

    private function graphData($data)
    {
        $count = [];
        foreach($data[0] as $value)
        {
            $count[] = $value['source'];
        }
        $countvalues = array_count_values($count);
        return $countvalues;
    }

    private function referrerCount($data)
    {
        $count = [];
        foreach($data[0] as $value)
        {
            $count[] = $value['source'];
        }
        $countvalues = array_count_values($count);
        arsort($countvalues);
        $finaloutput = [];
        list($source,$count) = array_divide($countvalues);
        foreach($source as $key=>$value)
        {
            $finaloutput[] = [
                'rank' => $key+1,
                'source' => $value,
                'count' => $count[$key]
            ];
        }
        return $finaloutput;
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
     * @param $sid
     * @return bool|mixed
     */
    public function checkSession($id,$sid)
    {
        $shortlink = ShortLink::where('hash','=',$sid)->first();
        $count = LinkView::where('session_id','=',$id)->where('shortlink_id','=',$shortlink->id)->count();
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

    /**
     * @param $data
     * @return array
     */
    public function getLocation($data)
    {
        $details = $data->toArray();
        $city = array_fetch($details,'city');
        $country = array_fetch($details,'country');
        $country_value = array_count_values($country);
        $city_value = array_count_values($city);
        arsort($country_value);
        arsort($city_value);
        list($countryname,$countrycount) = array_divide($country_value);
        list($cityname,$citycount) = array_divide($city_value);
        $top5_country = $this->top5country($countryname,$countrycount);
        $top5_cities = $this->top5cities($cityname,$citycount);
        return $output = ['top5cities' => $top5_cities,'top5countries' => $top5_country];
    }

    /**
     * @param $cname
     * @param $ccount
     * @return array
     */
    private function top5cities($cname,$ccount)
    {
        $output = [];
        foreach($cname as $key=>$value)
        {
            $output[] =
                [
                    'rank' => $key+1,
                    'city' => ($value == "") ? "Unknown" : $value,
                    'count' => $ccount[$key]
                ];
        }
        return array_slice($output,0,5,true);
    }

    /**
     * @param $cname
     * @param $ccount
     * @return array
     */
    private function top5country($cname,$ccount)
    {
        $output = [];
        foreach($cname as $key=>$value)
        {
            $output[] =
                [
                    'rank' => $key+1,
                    'country' => $value,
                    'count' => $ccount[$key]
                ];
        }
        return array_slice($output,0,5,true);
    }

    /**
     * @param $data
     * @return array|mixed
     */
    public function getMapData($data,$shortlink)
    {
        $details = $data->toArray();
        $lat = array_fetch($details,'latitude');
        $long = array_fetch($details,'longitude');
        list($latitude,$latcount) = array_divide(array_count_values($lat));
        list($longitude,$longcount) = array_divide(array_count_values($long));
        $output = $this->generateMapArray($latitude,$longitude,$latcount,$shortlink);
        return $output;
    }

    /**
     * @param $lat
     * @param $long
     * @param $count
     * @return array
     */
    private function generateMapArray($lat,$long,$count,$shortlink)
    {
        $output = [];

        foreach($lat as $key=>$value)
        {
            $data = Location::where('latitude','=',$value)->where('longitude','=',$long[$key])->where('shortlink_id','=',$shortlink)->remember(10)->first();
            $output[] =
                [
                    'latLng' => [$lat[$key],$long[$key]],
                    'name' => ($data['city'] == "") ? "Unknown" : $data['city'],
                    'count' => $count[$key]
                ];
        }
        return $output;
    }
}