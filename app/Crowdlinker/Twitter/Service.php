<?php namespace Crowdlinker\Twitter;

use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;

class Service
{
    /**
     * Post Tweet on Wall
     * @param $data
     * @param $token
     * @param $token_secret
     * @return array|bool|float|int|string
     */
    public function tweet($data,$token,$token_secret)
    {
        $client = new Client('https://api.twitter.com/1.1');
        $auth = new OauthPlugin(
            [
                'consumer_key' =>  $_ENV['TWITTER_KEY'],
                'consumer_secret' => $_ENV['TWITTER_SECRET'],
                'token' =>  $token,
                'token_secret' => $token_secret
            ]
        );

        $client->addSubscriber($auth);
        $request = $client->post('statuses/update.json?include_entities=true',null,
        [
            'status' => $data
        ]);
        $data = $request->send()->json();
        return $data;
    }
}