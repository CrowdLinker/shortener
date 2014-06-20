<?php namespace Crowdlinker\Shortener\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Register binding swith IoC container
     */
    public function register()
    {
        $this->app->bind(
            'Crowdlinker\Shortener\Repositories\LinkRepositoryInterface',
            'Crowdlinker\Shortener\Repositories\DbLinkRepository'
        );
    }
}