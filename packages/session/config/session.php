<?php
// Session configuration parameters.
Registry::$config['session'] = array 
(
	// Expiration time in seconds.
	'lifetime' => 7200,
	'name' => 'phpsession',
	'cookie' => array 
	(
		'path' => '/',
		'domain' => NULL,
		'secure' => FALSE,
		'httponly' => FALSE
	),
	/**
	 * Chance that garbage collection routine will be run.
	 * :NOTE: On debian systems, there are specific issues with 
	 * automatic garbage handling of session vars. The best practice is
	 * to set this to 0 and use an automated process to handle
	 * garbage collection.
	 */	 
	'gc_probability' => 0
);