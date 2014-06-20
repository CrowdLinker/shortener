<?php namespace Crowdlinker\Shortener;

use Illuminate\Support\ServiceProvider;

class ShortenerServiceProvider extends ServiceProvider {

    /**
     * Register in IoC container
     */
    public function register()
    {
        $this->app->bind('shortener', 'Crowdlinker\Shortener\ShortenerService');
    }

}