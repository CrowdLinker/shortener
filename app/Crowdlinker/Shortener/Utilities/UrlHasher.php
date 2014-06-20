<?php namespace Crowdlinker\Shortener\Utilities;

class UrlHasher
{
    /**
     * @var integer
     */
    protected $hasLength;

    public function __construct($hashLength)
    {
        $this->hashLength = $hashLength;
    }

    /**
     * Prepare URL hash
     * @param $url
     * @return string
     */
    public function make($url)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $this->hashLength);
    }

}
