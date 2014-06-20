<?php

class LocationCity extends \Eloquent {
	protected $fillable = [];
    protected $table = 'location_city';

    /**
     * Belongs to one location
     * @return mixed
     */
    public function location()
    {
        return $this->belongsTo('Location');
    }
}