<?php

class Referrer extends \Eloquent {
	protected $fillable = [];
    protected $table = 'referrer';


    /**
     * Belongs to Shortlink
     * @return mixed
     */
    public function shortlink()
    {
        return $this->belongsTo('ShortLink');
    }
}