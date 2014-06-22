<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    /**
     * User can create many shortlinks
     * @return mixed
     */
    public function shortlinks()
    {
       return $this->hasMany('ShortLink');
    }

    /**
     * User has many social Accounts
     * @return mixed
     */
    public function accounts()
    {
        return $this->hasMany('Account');
    }

}
