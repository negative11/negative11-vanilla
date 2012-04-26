<?php
/**
 * Establishes validation rule for jQuery-ui datetimepicker strings. 
 */
class Datetimepicker_Rule extends Validation_Component
{			
	/**
	 * Validates datetimepicker value. 
	 *
	 * @return boolean
	 */
	public function validate()
	{
		/**
		 * Regex for matching dates.
		 * Matches: 12/30/2002 | 01/12/1998 13:30 | 01/28/2002 22:35:00
		 * Non-Matches:	13/30/2002 | 01/12/1998 24:30 | 01/28/2002 22:35:64
		 * @author Spring Zhang
		 * @example http://regexlib.com/REDetails.aspx?regexp_id=230
		 */
		$result = (bool) (preg_match('/^([0]\d|[1][0-2])\/([0-2]\d|[3][0-1])\/([2][01]|[1][6-9])\d{2}(\s([0-1]\d|[2][0-3])(\:[0-5]\d){1,2})?$/', $this->clean));
		
		if ($result === FALSE)
		{
			$this->errors[] = "{$this->field_name} is not a valid date string.";
		}
		
		return $result;
	}
}