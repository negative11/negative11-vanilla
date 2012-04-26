<?php
/**
 * Establishes validation rule for common typing text strings.
 */
class Liberal_Punctuation_Text_Rule extends Validation_Component
{			
	/**
	 * Very text with loose punctuation checking.
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		// pN - numbers
		// pL - letters
		// p{P} - any kind of punctuation
		$result = (bool) (preg_match('/^[\pN\pL\p{P}\s]+$/uD', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = "{$this->field_name} contains non-standard characters.";
		}
		
		return $result;
	}
}