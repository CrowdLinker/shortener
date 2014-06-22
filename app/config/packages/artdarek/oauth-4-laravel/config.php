<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => $_ENV['FACEBOOK_ID'],
            'client_secret' => $_ENV['FACEBOOK_SECRET'],
            'scope'         => array('email','manage_pages'),
        ),		

	)

);