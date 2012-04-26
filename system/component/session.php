<?php
/**
 * Default session handler.
 * Handles automatic provision of a session for entire framework.
 * Provides convention for custom handler.
 */
class Session_Component
{	
	public function __construct()
	{
		// Set session lifetime.
		ini_set('session.gc_maxlifetime', Registry::$config['session']['lifetime']); 
		
		session_start();
	}
}