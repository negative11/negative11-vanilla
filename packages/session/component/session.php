<?php
/**
 * Provides session handling through the database.
 */
class Session_Component
{	
	/**
	 * @var Mysqli_Component
	 */
	private $db;
	
	public function __construct()
	{
		$this->db = new Mysqli_Component;
		
		// Overload default session handler.
		session_set_save_handler
		(
			array($this, 'open'),
			array($this, 'close'),
			array($this, 'read'),
			array($this, 'write'),
			array($this, 'destroy'),
			array($this, 'gc')
		);

		Loader::get('config', 'session');
		
		// Set session lifetime.
		ini_set('session.gc_maxlifetime', Registry::$config['session']['lifetime']); 
		
		// Set the garbage collection probablity.
		ini_set('session.gc_probability', Registry::$config['session']['gc_probability']);
		
		// Set the session name.
		session_name(Registry::$config['session']['name']);
		
		// Set cookie.
		session_set_cookie_params
		(
			Registry::$config['session']['lifetime'],
			Registry::$config['session']['cookie']['path'],
			Registry::$config['session']['cookie']['domain'],
			Registry::$config['session']['cookie']['secure'],
			Registry::$config['session']['cookie']['httponly']
		);
		
		// Start new session.
		session_start();
	}
	
	public function __destruct()
	{
		// Session write/close must be handled before destroying object.
		session_write_close();
	}
	
	/**
	 * Open session.
	 * 
	 * @param $save_path
	 * @param $session_name
	 */
	public function open($save_path, $session_name)
	{
		return TRUE;
	}
	
	/**
	 * Close session.
	 */
	public function close()
	{
		return TRUE;
	}
	
	
	/**
	 * Read session.
	 * 
	 * @param $session_id
	 */
	public function read($session_id)
	{
		try 
		{
			$result = $this->db->query
			(
				"
				SELECT 
					* 
				FROM 
					`sessions` 
				WHERE 
					`session_id` = ?
				", 
				$session_id
			);
						
			if ($result->count)
			{
				$data = $result->current()->data;				
				return unserialize($data);
			}
		}
		catch (Exception $e)
		{
			die ($e->getMessage());
		}
		
		return FALSE;
	}
	
	/**
	 * Write session data.
	 * 
	 * @param $session_id
	 * @param $data
	 */
	public function write($session_id, $data)
	{
		$data = serialize($data);
		
		try 
		{
			$this->db->query 
			(
				"
				INSERT INTO 
					`sessions`
				(
					session_id,
					data
				)
				VALUES
				(
					?,
					?
				)
				ON DUPLICATE KEY UPDATE 
					`data` = ?
				",
				$session_id,
				$data,
				$data
			);
		}
		catch (Exception $e)
		{
			die ($e->getMessage());
		}
	}
	
	/**
	 * Destory session.
	 * Remove all available session data, cookies, and database rows.
	 * 
	 * @param $session_id
	 */
	public function destroy($session_id)
	{
		$_SESSION = array();
		unset($_COOKIE[session_name()]);
		
		try 
		{
			$result = $this->db->query 
			(
				"
				DELETE FROM
					`sessions` 
				WHERE
					`session_id` = ?
				",
				$session_id
			);
		}
		catch (Exception $e)
		{
			die ($e->getMessage());
		}		
	}
	
	/**
	 * Garbage handler cleans up expired session.
	 * 
	 * @param integer $max_lifetime
	 */
	public function gc($max_lifetime)
	{
		$expires = time() - $max_lifetime;
		
		try 
		{
			$this->db->query 
			(
				"
				DELETE FROM
					`sessions` 
				WHERE
					`modified` < FROM_UNIXTIME({$expires})
				"
			);
		}
		catch (Exception $e)
		{
			die ($e->getMessage());
		}		
	}
}