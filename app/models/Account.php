<?php

class Account extends \Eloquent {
	protected $fillable = ['token','secret','expiry','provider','facebook_id','twitter_id'];
    protected $table = 'accounts';

    /**
     * Belongs To User;
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
}