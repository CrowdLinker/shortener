<?php namespace Crowdlinker\Twitter;

use Exception;
class Manager
{
    protected $providers = ['twitter'];

    public function has($name)
    {
        if(isset($this->providers[strtolower($name)])) return true;
        return false;
    }

    public function set($name,$provider)
    {
        $this->providers[strtolower($name)] = $provider;
    }

    public function get($name)
    {
        if($this->has(strtolower($name)))
        {
            return $this->providers[strtolower($name)];
        }
        throw new Exception("$name is not a valid property");
    }
}