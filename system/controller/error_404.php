<?php
/**
 * Standard 404 template
 * 
 * @package core
 */
class Error_404_Controller extends Core_Controller
{
	protected $template = '404';
	
	/**
	 * Force display.
	 */
	public function __destruct()
	{
		$this->template->display_content();
	}
}
