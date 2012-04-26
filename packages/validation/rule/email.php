<?php
/**
 * Establishes validation rule for email addresses.
 */
class Email_Rule extends Validation_Component
{		
	/**
	 * Length requirements
	 */
	public $range = array
	(
		3, 
		320
	);
	
	public $field_name = 'Email Address';
	
	/**
	 * Very simple email address validation.
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		$result = (bool) (preg_match('/[\w-]+@([\w-]+\.)+[\w-]+/', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = "{$this->field_name} is an invalid format.";
		}
		
		return $result;
	}
}