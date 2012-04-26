<?php
/**
 * Test some CRUD queries.
 */
class Crud_Test extends Test_Component
{
	public function crud_queries()
	{				
		// Instance the component.
		$db = new Mysqli_Component;	
		
		// Create a sample table. 
		//We will delete this later, so ensure this table does not already exist!
		$db->query 
		(
			'
			CREATE TABLE IF NOT EXISTS `example_temporary_table` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) NOT NULL,
			  `created` datetime NOT NULL,
			  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			)
			'
		);
		
		// CRUD model.
		$crud = new Crud_Model;
		$crud->table = 'example_temporary_table';
		
		// Create string row.
		$insert_id = $crud->create(array('name' => 'Barney'));				
		$this->expect_not_empty($insert_id);	
				
		// Create integer row.
		$insert_id = $crud->create(array('name' => 1234));	
		$this->expect_not_empty($insert_id);
		
		// Read a row.
		$row = $crud->read(1);
		$this->expect_object($row);
		
		// Read a row.
		$row = $crud->read(2);
		$this->expect_object($row);
		
		// Update a row.
		$affected = $crud->update(2, array('name' => 'Mortimer')); 
		$this->expect_not_empty($affected);
		
		// Read a row.
		$row = $crud->read(2);
		$this->expect_object($row);
		
		// Delete a row.
		$affected = $crud->delete(2);
		$this->expect_not_empty($affected);
		
		// Create string row.
		$insert_id = $crud->create(array('name' => 'Francis'));	
		$this->expect_not_empty($insert_id);
		
		// Set new column to Read/Update/Delete by.
		$crud->field = 'name';
				
		// Update a row by column.
		$affected = $crud->update('Francis', array('name' => 'James')); 
		$this->expect_not_empty($affected);
										
		// Clean up our sample table.
		$db->query('DROP TABLE `example_temporary_table`');
		
		
		// Show query log, current row, and total row count					
		$this->expect_array($db->get_query_log());	
	}
}