<?php namespace Crowdlinker\SnowPlow;

use Snowplow\RefererParser\Parser;
class snowplowApi
{
    public function parse($url,$slug)
    {
        $parser = new Parser();
        $referrer = $parser->parse($url,'http://crdln.kr/'.$slug);
        if($referrer->isKnown())
        {
            return $referrer->getSource();
        }
    }
}
