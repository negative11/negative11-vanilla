<?php
/**
 * Establishes validation rule for people names.
 */
class Name_Rule extends Validation_Component
{		
	/**
	 * Length requirements
	 */
	public $range = array
	(
		1, 
		255
	);
	
	public $field_name = 'Name';
	
	/**
	 * Very name fits standards.
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		$result = (bool) (preg_match('/^[-a-z0-9\'\s]+$/i', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = "{$this->field_name} is an invalid format.";
		}
		
		return $result;
	}
}