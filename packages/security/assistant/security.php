<?php
/**
 * Security_Assistant. 
 * 
 * @package security
 * @copyright negative(-11) Framework
 */
class Security_Assistant
{
	/**
	 * Generate a randomish token for various purposes.
	 * 
	 * @param string $salt
	 * @return string $token
	 */
	public static function token($salt = '_default_salt_')
	{
		$session_id = session_id();
		$microtime = microtime(TRUE);
		$seed = rand(0,1234567890);
		$seeded = $microtime . $seed;
		$url_friendly = '-..-__-*^$';
				
		$token = sha1(sha1($session_id) . md5($seeded) . $salt) . $url_friendly;		
		$pieces = str_split($token);
		shuffle($pieces);
		$token = implode('', $pieces) . 'T' . $microtime;
		
		return $token;
	}
	 
}
