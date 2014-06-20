<?php namespace Crowdlinker\GeoIP;

use GuzzleHttp\Client;

class geoipApi
{

    /**
     * Get location using freegeoip.net API
     * @param $ip
     * @return mixed
     */
    public function fetchdata($ip)
    {
        $url = 'http://freegeoip.net/json/'.$ip;
        $client = new Client(['base_url' => $url]);
        $request = $client->get();
        $response = json_encode($request->json());
        return json_decode($response,true);
    }
}
