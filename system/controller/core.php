<?php
/**
 * Base controller to be extended by all controllers
 */
class Core_Controller
{
	/**
	 * Whether this Controller should be loaded.
	 * This can be overridden in extending classes to enable/disable
	 * specific Controllers.
	 */
	const ENABLED = TRUE;
	
	/**
	 * Whether output should be drawn automatically on destroy.
	 */
	protected $auto_draw = TRUE;
	
	/**
	 * The template to be drawn
	 */
	protected $template;
	
	/**
	 * Constructor
	 * Setup any functionality that needs to run before the controller
	 * method.
	 */
	public function __construct()
	{
		if (!empty($this->template))
		{
			$this->template = new View_Component($this->template);
		}
	}
	
	/**
	 * Draws output.
	 * Any page content ready to be output is done via this method.
	 */
	public function draw()
	{
		if (Core::$draw_enabled)
		{
			if ($this->template instanceof View_Component)
			{
				$this->template->display_content();
			}
		}		
	}
	
	/**
	 * Destructor
	 * Finalize any actions before destroying object
	 */
	public function __destruct()
	{
		if ($this->auto_draw === TRUE)
		{
			$this->draw();
		}
	}
}
