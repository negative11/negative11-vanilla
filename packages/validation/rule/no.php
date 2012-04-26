<?php
/**
 * Pretty much allows anything through. Used to allow data to pass-thru, allowing the rest of the component to do its job.
 */
class No_Rule extends Validation_Component
{			
	/**
	 * Very text with loose punctuation checking.
	 * 
	 * @return boolean
	 */
	public function validate()
	{
		return TRUE;
	}
}