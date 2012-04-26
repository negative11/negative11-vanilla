<?php
/**
 * Test_Controller.
 * Performs lightweight unit testing on supplied class.
 * 
 * Tests should be supplied in a {package}/test folder and extend the Test_Component class
 * in order to utilize  'expect' methods used to check for expected values.
 * 
 * @package 
 * @copyright negative(-11) Framework
 */
class Test_Controller extends Core_Controller
{	
	/**
	 * Loads appropriate test.
	 * 
	 * @param string $name. Should correspond to a filename in 'tests/'.
	 * @return NULL
	 */
	public function main()
	{
		die ('Usage: /run/{test_name}');
	}
	
	/**
	 * Load and run a test.
	 * 
	 * @param string $name Name of test to run. This test should be located in {package}/tests
	 * folder.
	 * 
	 * @return NULL
	 */
	public function run($name)
	{
		// Ready the report.
		$report = new View_Component('test-result');
		$report->outcome = 'pass';
		$report->passes = 0;
		$report->fails = 0;
		$report->test_count = 0;
		$results = array();
				
		// Load test.
		$test = ucfirst(strtolower($name)) . '_Test';
		$report->test = $test;
		$reflector = new ReflectionClass($test);
						
		// Is it enabled?
		$constants = $reflector->getConstants();
		
		if ($constants['ENABLED'] === TRUE)
		{
			$report->status = 'Enabled';
			
			// Get the public methods, they are our tests.
			$public_methods = $reflector->getMethods(ReflectionMethod::IS_PUBLIC);
			$runnable = array();			
			foreach ($public_methods as $public_method)
			{
				$method = new ReflectionMethod($test, $public_method->name);
				
				// Constructor and Destructor should be used for setup/teardown only.
				if (!$method->isConstructor() && !$method->isDestructor())
				{
					$runnable[] = $method;
				} 
			}
			
			// Run each test.
			$report->test_count = count($runnable);
			foreach ($runnable as $run)
			{				
				$result = new stdClass;
				$result->test = $run->name;
				
				// Expectations will trigger Exceptions on failure.
				try 
				{
					$run->invoke(new $test);
					$result->outcome = 'pass';
					$report->passes++;
				}
				catch (Exception $e)
				{
					$report->fails++;
					$report->outcome = 'fail';	
					$result->outcome = 'fail';
					$result->error = $e->getMessage();				
				}
				
				array_push($results, $result);
			}				
		}
		else
		{
			$report->status = 'Disabled';
		}
		
		$report->results = $results;
		$report->display_content();
	}
	
}
 