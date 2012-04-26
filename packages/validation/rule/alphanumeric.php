<?php
/**
 * Establishes validation rule for alphanumeric text strings.
 */
class Alphanumeric_Rule extends Validation_Component
{			
	/**
	 * Very simple alphanumeric text validation
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		$result = (bool) (!preg_match('/[^a-z0-9]/i', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = "{$this->field_name} is not alphanumeric.";
		}
		
		return $result;
	}
}