<?php

class ShortLink extends \Eloquent {
	protected $fillable = ['url','hash','pagetitle','domainprovider'];
    protected $table = 'shortlink';

    /**
     * Belongs to User
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * Has Many Locations
     * @return mixed
     */
    public function locations()
    {
        return $this->hasMany('Location','shortlink_id');
    }

    /**
     * Has many referrers
     * @return mixed
     */
    public function referrers()
    {
        return $this->hasMany('Referrer','shortlink_id');
    }

    /**
     * Refresh/remove cache on save & delete
     */
    public static function boot()
    {
        parent::boot();
        static::saved(function()
        {
            Cache::flush();
        });

        static::created(function()
        {
            Cache::flush();
        });

        static::updating(function()
        {
            Cache::flush();
        });

        static::updated(function()
        {
            Cache::flush();
        });

        static::deleted(function()
        {
            Cache::flush();
        });
    }

}