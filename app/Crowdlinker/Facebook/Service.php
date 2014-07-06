<?php namespace Crowdlinker\Facebook;
use GuzzleHttp\Client;
class Service
{
    /**
     * Post on wall
     * @param $token
     * @param $data
     * @param $link
     * @return mixed|string|void
     */
    public function post($token,$data,$link)
    {
        $client = new Client(['base_url' => 'https://graph.facebook.com']);
        $params = ['access_token' => $token,'message' => $data,'link' => $link ];
        $request = $client->post('/v2.0/me/feed?'.http_build_query($params));
        $response = json_encode($request->json());
        return $response;
    }
}