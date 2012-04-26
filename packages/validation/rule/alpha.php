<?php
/**
 * Establishes validation rule for alpha text strings.
 */
class Alpha_Rule extends Validation_Component
{			
	/**
	 * Very simple alpha text validation
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		$result = (bool) (!preg_match('/[^a-z]/i', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = "{$this->field_name} is not a-Z.";
		}
		
		return $result;
	}
}