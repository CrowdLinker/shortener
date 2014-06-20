<?php namespace Crowdlinker\Shortener\Facades;

use Illuminate\Support\Facades\Facade;

class Shortener extends Facade {

    /**
     * Get name of binding in IoC container
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'shortener';
    }

}