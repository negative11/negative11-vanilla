<?php
/**
 * Security_Test_Controller 
 * 
 * @package 
 * @copyright negative(-11) Framework
 */
class Security_Test extends Test_Component
{		
	/**
	 * Test token functionality.
	 */
	public function get_token()
	{
		$token = Security_Assistant::token();
		$this->expect_not_empty($token);
	}	
}
 
