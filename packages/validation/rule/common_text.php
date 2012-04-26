<?php
/**
 * Establishes validation rule for common typing text strings.
 */
class Common_Text_Rule extends Validation_Component
{			
	/**
	 * Very simple alpha text validation
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		// pN - numbers
		// pL - letters
		// p{Po} - normal puncuation
		$result = (bool) (preg_match('/^[\pN\pL\p{Po}\s\_\-]+$/uD', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = "{$this->field_name} contains non-standard characters.";
		}
		
		return $result;
	}
}