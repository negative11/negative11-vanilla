<?php
/**
 * Test Component.
 * Provides expectations for extending test classes to utilize. 
 * 
 * @package test
 * @copyright negative(-11) Framework
 */
abstract class Test_Component
{
	/**
	 * Is the extending test class enabled?
	 */
	const ENABLED = TRUE;
	
	/**
	 * Whether tests should output verbose details.
	 * This typically means that data supplied to the test will
	 * be displayed in core::dump() format.
	 */
	const VERBOSE = FALSE;
	
	/**
	 * Expects to be supplied TRUE.
	 * 
	 * @param mixed $value
	 * @return NULL
	 */
	protected function expect_boolean_true($value)
	{
		if ($value !== TRUE)
		{
			throw new Exception ('Expected boolean(TRUE).');
		}
	}
	
	/**
	 * Expects to be supplied FALSE.
	 * 
	 * @param mixed $value
	 * @return NULL
	 */
	protected function expect_boolean_false($value)
	{
		if ($value !== FALSE)
		{
			throw new Exception ('Expected boolean(FALSE).');
		}
	}
	
	/**
	 * Expects to be supplied an object.
	 * 
	 * @param mixed $value
	 * @pararm string $type Optional type to compare value instance to.
	 * @return NULL
	 */
	protected function expect_object($value, $type = NULL)
	{
		if (!is_object($value))
		{
			throw new Exception ('Expected object.');
		}
		
		if (isset($type))
		{
			if (!$value instanceof $type)
			{
				throw new Exception ('Expected instance of ' . $type);
			}
		}	
	}	
	
	/**
	 * Expects to be supplied an array
	 * 
	 * @param mixed $value
	 * @return NULL
	 */
	protected function expect_array($value)
	{
		if (!is_array($value))
		{
			throw new Exception ('Expected array().');
		}
	}
	
	/**
	 * Expects value to be empty
	 * 
	 * @param mixed $value
	 * @return NULL
	 */
	protected function expect_empty($value)
	{
		if (!empty($value))
		{
			throw new Exception('Expected empty value.');
		}
	}
	
	/**
	 * Expects value to NOT be empty.
	 * 
	 * @param mixed $value
	 * @return NULL
	 */
	protected function expect_not_empty($value)
	{
		if (empty($value))
		{
			throw new Exception('Expected non empty value.');
		}
	}
	
}