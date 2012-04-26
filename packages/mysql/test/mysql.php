<?php
/**
 * Test some queries.
 */
class Mysql_Test extends Test_Component
{
	/**
	 * Run some queries.
	 */
	public function create_insert_drop_rows()
	{				
		// Instance the component.
		$db = new Mysqli_Component;	
		
		// Create a sample table. 
		//We will delete this later, so ensure this table does not already exist!
		$result = $db->query 
		(
			'
			CREATE TABLE IF NOT EXISTS `example_temporary_table` (
			  `id` integer UNSIGNED NOT NULL AUTO_INCREMENT,
			  `name` varchar(255)  NOT NULL,
			  PRIMARY KEY (`id`)
			)
			'
		);
		
		// Expect a result object.
		$this->expect_object($result);
		
		// Add some rows to our table. Demonstrates query binding.
		$result = $db->query
		(
			'
			INSERT INTO
				`example_temporary_table`
			(
				`name`
			)
			VALUES (?),(?),(?),(?),(?)
			',
			'Tom',
			'Bob',
			'Ingrid',
			'Sam',
			'James'
		);
		
		// Expect a result object.
		$this->expect_object($result);
		
		// Run a sample query on table	
		$result = $db->query('SELECT * FROM example_temporary_table a LIMIT ?,?', 0, 5);
		
		// Expect a result object.
		$this->expect_object($result);
		
		// Clean up our sample table.
		$db->query('DROP TABLE `example_temporary_table`');
				
		// Demonstrate foreach through result				
		$row_ids = array();
		foreach ($result as $row)
		{
			$row_ids[] = $row->name;
		}		
		
		// Show query log, current row, and total row count					
		$this->expect_array($db->get_query_log());
	}
}