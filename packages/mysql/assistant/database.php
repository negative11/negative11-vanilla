<?php
/**
 * Database_Assistant.  
 * 
 * @package mysql
 * @copyright negative(-11) Framework.
 */
class Database_Assistant
{
	/**
	 * Make `column` = ? binds out of supplied associative array.
	 * 
	 * @param array $array
	 * @param string $delimiter ',', AND, OR, etc.
	 * @return string
	 */	 
	public static function bind(array $array = array(), $delimiter = ',')
	{
		if (count($array))
		{
			$binds = array();
			foreach (array_keys($array) as $key)
			{
				$binds[] = "`{$key}` = ?";
			}
			
			return implode(" {$delimiter} ", $binds);
		}
		
		return NULL;
	}
	
	/**
	 * Creates ORDERBY statement from array values.
	 * 
	 * @param array $orderby
	 * @return string
	 */
	public static function orderby(array $orderby = array())
	{
		if (count($orderby))
		{
			$sorts = array();
						
			foreach ($orderby as $column => $value)
			{
				$sorts[] = "`{$column}` {$value}"; 
			}
			 
			return ' ORDER BY ' . implode(',', $sorts);
		}
		
		return NULL;
	}
	
	/**
	 * Creates WHERE statment from array values.
	 * Uses simple WHERE col = val patterns.
	 * 
	 * :TODO: Implement more complex builder.
	 * 
	 * @param array $where
	 * @return string
	 */
	public static function where(array $where = array())
	{
		if (count($where))
		{
			$conditions = array();
						
			foreach ($where as $column => $value)
			{
				if (is_numeric($value))
				{
					$conditions[] = "`{$column}` = {$value}";
				}
				elseif ($value instanceof Literal_Assistant)
				{
					$conditions[] = "{$column} {$value}";
				}
				else
				{
					$conditions[] = "`{$column}` = '{$value}'";
				}
			}
			 
			return ' WHERE ' . implode(' AND ', $conditions);
		}
		
		return NULL;
	}
	
	/**
	 * Build LIMIT statement.
	 * 
	 * @param integer $limit
	 * @param integer $offset
	 * 
	 * @return string
	 */
	public static function limit($limit = NULL, $offset = NULL)
	{
		if (isset($limit, $offset))
		{
			return ' LIMIT ' . (int) $offset . ',' . (int) $limit;
		}
		elseif (isset($limit))
		{
			return ' LIMIT ' . (int) $limit;
		}
		
		return NULL;
	}	 
}
