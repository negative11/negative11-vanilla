<?php
/**
 * Sample test file. 
 * 
 * @package test 
 * @copyright negative(-11) Framework
 */
class Example_Test extends Test_Component
{
	/**
	 * Is this unit test enabled?
	 * This constant is set to TRUE by default in
	 * the Test_Component class.
	 */
	const ENABLED = TRUE;
	
	/**
	 * Constructor (Setup).
	 * Each test method will be run in a new instance of this class.
	 * If the test needs access to a model, database connection, etc.,
	 * that should be done here.
	 */
	public function __construct()
	{
	}
	
	/**
	 * Destructor (Teardown).
	 * Each test method will be run in a new instance of this class.
	 * If the test needs to clean up after itself, that should be done here.
	 */
	public function __destruct()
	{
	}
	
	/**
	 * This test should be run, because it is public.
	 */
	public function boolean_example()
	{
		$this->expect_boolean_true(TRUE);
		$this->expect_boolean_false(FALSE);
	}
	
	/**
	 * 
	 * @param
	 * @return
	 */
	public function array_example()
	{
		$array = array(1, 2, 3, 4, 5, 'bananas');
		
		$this->expect_array($array);
	}
	
	/**
	 * 
	 * @param
	 * @return
	 */
	public function object_example()
	{
		$object = new stdClass;
		$object->name = 'myobject';
		
		// Is it an object?
		$this->expect_object($object);
		
		// Is it an instance of stdClass?
		$this->expect_object($object, 'stdClass');
	}
	
	/**
	 * 
	 * @param
	 * @return
	 */
	public function empty_example()
	{
		$value = FALSE;
		$this->expect_empty($value);
		
		$value = NULL;
		$this->expect_empty($value);
		
		$value = 0;
		$this->expect_empty($value);
		
		$value = '';
		$this->expect_empty($value);
	}
	
	/**
	 * 
	 * @param
	 * @return
	 */
	public function not_empty_example()
	{
		$value = 'something';
		$this->expect_not_empty($value);
	}
	
	
	
	/**
	 * This test should fail.
	 */
	public function failed_test_example()
	{
		$this->expect_array('not an array');
	}	
}