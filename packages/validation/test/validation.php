<?php
/**
 * Validation Rules test. 
 * 
 * @package validation.
 * @copyright negative(-11) Framework
 */
class Validation_Test extends Test_Component
{
	/**
	 * Is this unit test enabled?
	 * This constant is set to TRUE by default in
	 * the Test_Component class.
	 */
	const ENABLED = TRUE;

	/**
	 * 
	 * @param
	 * @return
	 */
	public function datetimepicker()
	{
		// Validate Published
		$published = new Datetimepicker_Rule('03/23/2011 04:09');
		$published->required = TRUE;
		$published->field_name = 'Publish Date';
		$published->run();				
		$this->expect_boolean_true($published->valid);
		
		// Validate Published fails
		$published = new Datetimepicker_Rule('55/66/9999 04:09');
		$published->required = TRUE;
		$published->field_name = 'Publish Date';
		$published->run();		
		$this->expect_boolean_false($published->valid);
	}
	
	/**
	 * Test email validation
	 */
	public function email()
	{		
		$email = new Email_Rule('nobody@example.com');
		$email->run();		
		$this->expect_boolean_true($email->valid);
	}
	
	/**
	 * Test alpha text.
	 */
	public function alpha()
	{		
		$alpha = new Alpha_Rule('ABCDEfg');
		$alpha->run();				
		$this->expect_boolean_true($alpha->valid);
	}
	
	/**
	 * Test alphanumeric text.
	 */
	public function alphanumeric()
	{		
		$alphanumeric = new Alphanumeric_Rule('abc123');
		$alphanumeric->run();		
		$this->expect_boolean_true($alphanumeric->valid);
	}
	
	/**
	 * Test common text.
	 */
	public function common_text()
	{		
		$common = new Common_Text_Rule('Just a sample sentence!');
		$common->run();
		$this->expect_boolean_true($common->valid);
				
		$common = new Common_Text_Rule('Account Balance -123.45 credit');
		$common->run();		
		$this->expect_boolean_true($common->valid);
				
		$common = new Common_Text_Rule('Thi$ should FAIL!!!: Did it?');
		$common->run();		
		$this->expect_boolean_false($common->valid);
	}
	
	/**
	 * Test numeric
	 */
	public function numeric()
	{		
		$numeric = new Numeric_Rule(123.45);
		$numeric->run();		
		$this->expect_boolean_true($numeric->valid);
				
		$numeric = new Numeric_Rule(123);
		$numeric->run();				
		$this->expect_boolean_true($numeric->valid);
	}
	
	
	/**
	 * Test US-format telephone number.
	 */
	public function phone()
	{		
		$phone = new Phone_Rule('800-555-2424');
		$phone->run();
		$this->expect_boolean_true($phone->valid);
		
		$phone = new Phone_Rule('8005552424');
		$phone->run();
		$this->expect_boolean_true($phone->valid);
	}
}