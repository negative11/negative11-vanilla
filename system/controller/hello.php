<?php
/**
 * Default system controller that tells us the framework is here, and
 * that it is alive.
 */
class Hello_Controller extends Core_Controller
{
	/**
	 * Overload parent template.
	 * Relative to system/template/
	 */
	protected $template = 'hello';
	
	public function __construct()
	{				
		// Disabled in production
		if (IN_PRODUCTION === TRUE)
		{
			Core::error_404();
		}
		
		parent::__construct();
	}
	
	public function main()
	{
		// Display some statistics
		$this->template->framework = Registry::$framework;	
		
		// Load distribution-specific examples.
		$examples = new View_Component('examples');
		
		// You can embed template output into other templates...
		$this->template->examples = $examples->get_content();
		
		
	}
}
