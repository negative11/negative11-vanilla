<?php
/**
 * Allows Controller class to delegate actions to other Controller classes
 * located in the subdirectory relative to itself.
 * 
 * @package 
 * @subpackage 
 * @copyright johnsquibb.com
 */
class Sub_Controller
{
	/**
	 * Constructor.
	 * Acts as mini Router that picks up at the Controller level, post-routing.
	 * Searches for files in directory relative to delegating class.
	 * 
	 * Uses argument already set in Router as provided in URL. 
	 * 
	 * The URL parameter that would ordinarily be the method is now the subdirectory
	 * The URL parameter that would be the first method parameter is now the controller.
	 * The URL paramter that would be the second method parameter is now the method.
	 * 
	 * Any remaining URL parameters are passed along as method parameters for the
	 * Subcontroller invoked.
	 */
	public function __construct()
	{		
		// Find the file in the directory relative to the original Controller.
		$subdirectory = dirname($this->file) . '/' . Router::$method ;
		$file = strtolower(array_shift(Router::$arguments));
		$path = $subdirectory . '/' . $file . FILE_EXTENSION;
		$default_path = $subdirectory . '/' . Router::$method . FILE_EXTENSION;

		if (file_exists($path))
		{
			Loader::load($path);
			$controller = ucfirst($file) . '_Controller';			
			
			if (count(Router::$arguments))
			{
				Router::$method = array_shift(Router::$arguments);	
			}
			else
			{
				Router::$method = Registry::$config['core']['default_controller_method'];
			}
			
			Core::run_controller($controller);
		}
		elseif (file_exists($default_path))
		{
			// Check for a default file of the same name as the directory, and load that with the default method.
			Loader::load($default_path);
			$controller = ucfirst(strtolower(Router::$method)) . '_Controller';
			Router::$method = Registry::$config['core']['default_controller_method'];
			Core::run_controller($controller);
		}
		else
		{			
			// No matches.
			Core::error_404();
		}
		
		// Exit to prevent Router from continuing in Core.
		exit;
	}
}
 