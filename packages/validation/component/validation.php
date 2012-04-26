<?php
/**
 * Validation Component.
 * Provides base functionality of validation classes to be extended by
 * a more specific implementation in a Validation_Rule class.
 */
abstract class Validation_Component
{
	/**
	 * @var boolean $required
	 * 
	 * Is this element required?
	 */
	public $required = FALSE;
	
	/**
	 * @var $original
	 * 
	 * The original value submitted on __construct()
	 */
	public $original;
	
	/**
	 * @var $clean
	 * 
	 * The clean value.
	 */
	public $clean;
	
	/**
	 * @var $valid
	 * 
	 * The valid value.
	 */
	public $valid = TRUE;
	
	/**
	 * @var array $range
	 * 
	 * Range requirements.
	 * 
	 * Specify one argument for exact length, two for range.
	 * First element is minimum length, second is maximum length.
	 * 
	 * Leave empty for no required range.
	 */
	public $range = array
	(
		// Exact length
		//42,
		
		
		// or
		
		
		// Minimum length 
		//0,
		
		// Maximum length
		//255,
	);
	
	/**
	 * @var array $errors
	 * 
	 * Contains any errors that may occur.
	 */
	public $errors = array();
	
	/**
	 * Field name to use in errors or other output.
	 */
	public $field_name = 'Value';
	
	/**
	 * Whether to allow HTML tags during standard cleaners.
	 */
	public $allow_html_tags = FALSE;
	
	/**
	 * Constructor.
	 * 
	 * Saves original value, runs standard cleaner methods.
	 */
	public function __construct($value)
	{
		$this->original = $value;	
	} 
	
	/**
	 * The validate method must be defined in the extending Rule class.
	 */
	abstract public function validate();
	
	/**
	 * Stub. Extend in your Rule class if needed.
	 */
	public function clean()
	{
		return TRUE;
	}
	
	/**
	 * Checks for value in a required field
	 * 
	 * @return boolean pass
	 */
	public function check_required()
	{
		if ($this->required === TRUE)
		{
			if (empty($this->clean) || $this->clean === '')
			{
				$this->errors[] = "{$this->field_name} is required. Empty or '' supplied.";
				
				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	/**
	 * Checks value against range requirements
	 * 
	 * @return boolean pass
	 */
	public function check_range()
	{
		if (!empty($this->range))
		{
			$length = strlen($this->clean);
			
			switch (count($this->range))
			{
				// Exact length
				case 1:
				
					if ($length != $this->range[0])
					{
						$this->errors[] = 
						(
							"{$this->field_name} must be exactly " . 
							$this->range[0] . 
							' characters in length.'
						);
						
						return FALSE;
					}
				
				break;
				
				// Min/Max length
				case 2:
				
					if ($length < $this->range[0] || $length > $this->range[1])
					{
						$this->errors[] = 
						(
							"{$this->field_name} must be between " . 
							$this->range[0] . 
							' and ' . 
							$this->range[1] .
							' characters in length.'
						);
						
						return FALSE;
					} 
				
				break;
			}
		}
		
		return TRUE;
	}
	
	/**
	 * Runs standard set of cleaner methods for any value supplied 
	 * during construct.
	 */
	public function standard_cleaners()
	{
		$this->clean = trim($this->original);
		
		if (!$this->allow_html_tags)
		{
			// Strip all HTML.
			$this->clean = strip_tags($this->clean);
		}
		
		return TRUE;
	}	
	
	/**
	 * Runs validation processes.
	 * 
	 * Checks for required fields, ranges, and any defined validation
	 * and cleaner methods.
	 * 
	 * @return boolean.
	 * A failure at any point will return FALSE.
	 * If everything passes, TRUE is returned.
	 */
	final public function run()
	{
		// Apply standard cleaner methods.
		$this->valid &= $this->standard_cleaners();	
		
		// Apply custom cleaners
		$this->valid &= $this->clean();
		
		// Check required
		$this->valid &= $this->check_required();		
				
		// Check length
		$this->valid &= $this->check_range();
		
		// Run custom validation 
		$this->valid &= $this->validate();
		
		$this->valid = (bool) $this->valid;		
		return $this->valid;
	}
}