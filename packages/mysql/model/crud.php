<?php
/**
 * Simple CRUD model for create, read, update, delete of single rows.  
 * Can be used directly, but is typically extended by another model to add 
 * methods to its base.
 * 
 * @package 
 * @subpackage 
 * @copyright johnsquibb.com
 */
class Crud_Model extends Core_Model
{
	/**
	 * @var Mysqli_Component
	 */
	protected $db;
	
	/**
	 * @var string Table to read from.
	 */
	public $table;
	
	/**
	 * @var string Field to use for value comparison.
	 */
	public $field = 'id';
				
	/**
	 * Constructor.
	 * Establishes connection to database.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->db = new Mysqli_Component;
	}
	
	/**
	 * Add a new row to table.
	 * 
	 * @param array $data Array of field => value pairs.
	 * @return mysqli_insert_id()
	 */
	public function create(array $data)
	{
		try
		{
			$result = $this->db->query
			(
				'INSERT INTO `' . $this->table . '`' . 
				' SET ' . Database_Assistant::bind($data),
				array_values($data)
			);
			
			return $result->insert_id;
		}
		catch (Exception $e)    
		{
			throw new Exception ('Could not create row: ' . $e->getMessage());
		}		 
	}
	
	/**
	 * Read a single row from table.
	 * This is typically done using the primary key.
	 * 
	 * @param mixed $value Value of field to fetch.
	 * @return object row
	 */
	public function read($value)
	{
		try
		{
			$result = $this->db->query("SELECT * FROM `{$this->table}` WHERE `{$this->field}` = ? LIMIT 1", $value);
			
			if ($result->count)
			{
				return $result->current();
			}
		}
		catch (Exception $e)    
		{
			throw new Exception ('Could not get row: ' . $e->getMessage());
		}		 
	}
	
	/**
	 * Read many rows from table.
	 * 
	 * @param array $where WHERE conditions
	 * @param array $orderby ORDERBY conditions
	 * @param integer $limit Optional limit
	 * @param integer $offset Optional offset
	 * 
	 * @return array
	 */
	public function read_many(array $where = array(), array $orderby = array(), $limit = NULL, $offset = NULL)
	{
		$rows = array();
		
		$where_statement = Database_Assistant::where($where);
		$orderby_statement = Database_Assistant::orderby($orderby);
		$limit_statement = Database_Assistant::limit($limit, $offset);
		
		try
		{
			$result = $this->db->query("SELECT * FROM `{$this->table}` {$where_statement} {$orderby_statement} {$limit_statement}");
			
			if ($result->count)
			{
				foreach ($result as $row)
				{
					$rows[] = $row;
				}
			}
		}
		catch (Exception $e)    
		{
			throw new Exception ('Could not get rows: ' . $e->getMessage());
		}	
		
		
		return $rows;
	}
	
	/**
	 * 
	 * @param mixed $value Value of field to update
	 * @param array $data fields to update
	 * @return integer affected rows
	 */
	public function update($value, array $data)
	{
		try
		{
			$result = $this->db->query
			(
				"UPDATE `{$this->table}` SET " . 
				Database_Assistant::bind($data, ',') . 
				" WHERE `{$this->field}` = ? LIMIT 1",
				array_merge(array_values($data), array($value))
			);
			
			return $result->affected;
		}
		catch (Exception $e)    
		{
			throw new Exception ('Could not update row: ' . $e->getMessage());
		}		 
	}
	
	/**
	 * Delete a single row.
	 * 
	 * @param mixed $value Value of field to delete.
	 * @return integer affected rows
	 */
	public function delete($value)
	{
		try
		{
			$result = $this->db->query("DELETE FROM `{$this->table}` WHERE `{$this->field}` = ? LIMIT 1", $value);			
			return $result->affected;
		}
		catch (Exception $e)    
		{
			throw new Exception ('Could not delete row: ' . $e->getMessage());
		}		 
	}
}