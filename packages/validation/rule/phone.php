<?php
/**
 * Establishes validation rule for US-format phone numbers. 
 * 
 * @see Original regex by <kode kode>
 * @see http://regexlib.com/UserPatterns.aspx?authorId=b6740171-d8dc-4162-a402-f097480b6de4
 */
class Phone_Rule extends Validation_Component
{			
	/**
	 * Very simple numeric validation
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		$result = (bool) (preg_match('/^\(?[\d]{3}\)?[\s-]?[\d]{3}[\s-]?[\d]{4}$/', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = 'Phone number is not valid US format.';
		}
		
		return $result;
	}
}