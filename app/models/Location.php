<?php

class Location extends \Eloquent {
	protected $fillable = [];
    protected $table = 'location';

    /**
     * Belongs to shortlink
     * @return mixed
     */
    public function shortlink()
    {
        return $this->belongsTo('shortlink');
    }
}