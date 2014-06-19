<?php namespace Crowdlinker\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Crowdlinker\Repositories\UserInterface',
            'Crowdlinker\Repositories\DbUserRepository'
        );
    }
}