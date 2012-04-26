<?php
/**
 * Defines configuration parameters for MySQL Improved functionality.
 */

// Prepare query log
Registry::$info['query_log'] = array();

// Set connection parameters
Registry::$config['mysqli'] = array 
(
	// The primary database connection
	'primary' => array 
	(
		'host' => 'localhost',
		'username' => 'user',
		'password' => 'p4ssw0rd',
		'database' => 'example',
		'port' => 3306,
		'socket' => NULL
	)
);