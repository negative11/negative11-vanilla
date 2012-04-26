<?php
/**
 * MySQL Improved abstraction layer provides the following 
 * functionality:
 * 		
 * 	Uses PHP MySQL Improved Extension. 
 * 	@see http://us3.php.net/mysqli
 *
 * 	Connects to MySQL using parameters defined in config.
 * 		
 * 	Query binding via arbitrary arguments supplied to the query()
 * 	method. Also prepares data with mysqli_real_escape_string.
 * 
 * 	Results returned in the form of result objects.
 *  
 *  @package mysqli
 */
class Mysqli_Component
{
	/**
	 * Connection to MySQLi is created in __construct.
	 */
	public $connection;
	
	/**
	 * Constructor.
	 * 
	 * @param string $connection_name The array index of the connection
	 * to use as defined in config/mysqli.php and set in Registry.
	 */
	public function __construct($connection_name = 'primary')
	{
		// Load configuration
		Loader::get('config', 'mysqli');
		$config = Registry::$config['mysqli'][$connection_name];
		
		// Create connection
		$this->connection = new mysqli
		(
			$config['host'], 
			$config['username'], 
			$config['password'], 
			$config['database'], 
			$config['port'], 
			$config['socket']
		); 
	}
	
	/**
	 * Binds query parameters if supplied.
	 * Delegates execution of supplied query to, and supplies internal
	 * connection to Mysqli_Result_Component object.
	 * 
	 * @param string $sql
	 * @param mixed Additional unlimited arguments are treated as query
	 * binds.
	 * @return Mysqli_Result_Component $result
	 */
	public function query($sql, $binds = NULL)
	{
		// First argument must be $sql
		$arguments = func_get_args();
		$sql = array_shift($arguments);
		
		// Any subsequent args are considered binds
		if (count($arguments) >= 1)
		{
			// Binds can be passed as an array, or as individual arguments, but not both.
			if (is_array($arguments[0]))
			{
				$arguments = $arguments[0];
			}
				
			$binds = $arguments;
						
			// Distinguish binds from actual punctuation.
			$macro = '_BIND_';
			$sql = str_replace('?', $macro, $sql);

			foreach ($binds as $bind)
			{
				// Safe values only. Literal statements are ok.
				if ($bind instanceof Literal_Assistant)
				{
					$value = (string) $bind;
				}
				else
				{
					$value = $this->connection->real_escape_string($bind);
					if (!is_numeric($value))
					{
						$value = "'{$value}'";
					}
				}
				
				// Replace bind
				$next = strpos($sql, $macro);
				$sql = substr($sql, 0, $next) . $value . substr($sql, ($next + strlen($macro)));
			}						
		
			// Flush any leftover binds. 
			$sql = str_replace($macro, '?', $sql);
		}
		
		// Generate result object
		if (is_object($this->connection))
		{
			// Log query
			Registry::$info['query_log'][] = $sql;	
			
			return new Mysqli_Result_Component($this->connection, trim($sql));
		}
		
		return FALSE;
	}
	
	/**
	 * Returns any queries that have been logged during $this->query().
	 */
	public function get_query_log()
	{
		return Registry::$info['query_log'];
	}
	
} // End Mysqli_Component

/**
 * Provides interactive result object that utilizes SPL Iterator for 
 * advanced negotiation of the MySQLi result.
 * 
 * @package mysqli
 */
class Mysqli_Result_Component implements Iterator
{
	/**
	 * Current offset.
	 */
	protected $row;
	
	/**
	 * MySQLi result resource supplied in __construct.
	 */
	protected $result;
	
	/**
	 * Number of rows in result set.
	 */
	public $count;
	
	/**
	 * Number of affected rows in result set, for UPDATE/DELETE
	 */
	public $affected;
	
	/**
	 * Generated identifier for an INSERT query.
	 */
	public $insert_id;
		
	/**
	 * Constructor.
	 * Performs query and stores the result.
	 * 
	 * @param resource $result
	 */
	public function __construct($connection, $sql)
	{	
		// Execute supplied query using supplied connection.
		$result = $connection->multi_query($sql);
		
		// Errors?
		if ($result === FALSE)
		{
			throw new Exception ($connection->error . ' ' . $sql);
		}
		
		// Save result, we'll use SPL iterator to go through it later.
		$this->result = $connection->store_result();
		
		// There may be some additional data available, depending on query type.
		if (is_object($this->result))
		{
			$this->row = 0;
			$this->count = $this->result->num_rows;
		}
		else
		{
			// Some queries affect rows, such as INSERT, UPDATE, or DELETE.
			$this->insert_id = $connection->insert_id;
			$this->affected = $connection->affected_rows;
		}	
	}	
	
	public function __destruct()
	{
		// Flush memory
		if (is_object($this->result))
		{
			$this->result->free_result();
		}
	}
	
	/**
	 * Searches for particular offset in result.
	 * 
	 * @param integer $offset
	 * @return TRUE
	 */
	public function seek($offset)
	{
		$this->result->data_seek($offset);
		return TRUE;
	}
	
	/**
	 * Returns next row of result data.
	 * 
	 * @return object $row
	 */
	public function current()
	{
		$this->seek($this->row);
		return $this->result->fetch_object();
	}
		
	/**
	 * Returns current row number
	 */
	public function key()
	{
		return $this->row;
	}
	
	/** 
	 * Increments the row number
	 * 
	 */
	public function next()
	{
		++$this->row;
	}
	
	/** 
	 * Decrements the row number
	 * 
	 */
	public function previous()
	{
		--$this->row;
	}
	
	/**
	 * Resets the row number and seeks the result back.
	 * 
	 */
	public function rewind()
	{
		$this->row = 0;
	}
	
	/**
	 * Returns whether current row number is a valid row based on total
	 * number of available rows in result resource.
	 * 
	 * @return bool
	 */
	public function valid()
	{
		return (bool) ($this->row < $this->count);
	}	

} // End Mysqli_Result_Component