<?php
/**
 * Establishes validation rule for passwords.
 */
class Password_Rule extends Validation_Component
{		
	/**
	 * Length requirements
	 */
	public $range = array(6,25);
	
	public $field_name = 'Password';
	
	/**
	 * Very password fits standards.
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		$result = (bool) (preg_match('/^.+$/i', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = "{$this->field_name} is an invalid format.";
		}
		
		return $result;
	}
}