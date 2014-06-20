<?php namespace Crowdlinker\Shortener\Utilities;
use Illuminate\Support\ServiceProvider;
use Crowdlinker\Shortener\Utilities\UrlHasher;

class UtilitiesServiceProvider extends ServiceProvider {

    /**
     * Register in IoC container
     */
    public function register()
    {
        $this->app->bind('Crowdlinker\Shortener\Utilities\UrlHasher', function()
        {
            $length = 5;

            return new UrlHasher($length);
        });
    }

}
