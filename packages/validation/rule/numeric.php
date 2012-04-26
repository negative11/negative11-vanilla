<?php
/**
 * Establishes validation rule for numeric strings. 
 * May contain only digits, or digits and a decimal.
 */
class Numeric_Rule extends Validation_Component
{			
	/**
	 * Very simple numeric validation
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		$result = (bool) (preg_match('/^\d*\.?\d*$/', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = "{$this->field_name} is not a number.";
		}
		
		return $result;
	}
}