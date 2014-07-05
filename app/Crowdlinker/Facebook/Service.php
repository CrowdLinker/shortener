<?php namespace Crowdlinker\Facebook;
use GuzzleHttp\Client;
class Service
{
    /**
     * Post on facebook's wall
     * @param $token
     * @param $data
     * @return mixed|string|void
     */
    public function post($token,$data)
    {
        $client = new Client(['base_url' => 'https://graph.facebook.com']);
        $params = ['access_token' => $token,'message' => $data];
        $request = $client->post('/v2.0/me/feed?'.http_build_query($params));
        $response = json_encode($request->json());
        return $response;
    }
}