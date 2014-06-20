<?php namespace Crowdlinker\Embedly;

use GuzzleHttp\Client;

class EmbedlyApi
{

    /**
     * Get url embed info
     * @param $url
     * @return mixed
     */
    public function fetchdata($url)
    {
        //$client = new Client(['base_url' => 'http://api.embed.ly/1/oembed']);
        $client = new Client(['base_url' => 'http://api.embed.ly/1/extract']);
        $params = array
        (
            'key' => $_ENV['EMBEDLY_KEY'],
            'url' => $url
        );

        $request = $client->get('?'.http_build_query($params));
        $response = json_encode($request->json());
        return json_decode($response,true);
    }
}
