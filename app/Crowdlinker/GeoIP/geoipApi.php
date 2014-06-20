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
        $client = new Client(['base_url' => 'freegeoip.net']);
        $request = $client->get('/json/'.$ip);
        $response = json_encode($request->json());
        return json_decode($response,true);
    }
}
