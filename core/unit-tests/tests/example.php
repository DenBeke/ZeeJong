<?php


namespace UnitTest;



function divide($a, $b) {
	/*
	Normally you would throw an exception...
	But if you don't, the performed test will give an error
	
	if($b == 0) {
		throw new Exception('Cannot divide by ZERO');
	}
	*/
}


class Example extends UnitTest {
	
	
	private $testVarA;
	private $testVarB;
	
	
	public function __construct() {
		
		$this->testVarA = 'A random text string that will not be needed to redefined during the tests.';
		
	}
	
	
	public function Assignment() {
		
		$this->testVarB = $this->testVarA;
		$this->REQUIRE_EQUAL($this->testVarB, $this->testVarA);
		
	}
	
	
	public function AnotherTest() {
		
		$var = explode(' ', $this->testVarA);
		$var = implode(' ', $var);
		
		$this->REQUIRE_EQUAL($var, $this->testVarA);
		$this->REQUIRE_NOTEQUAL('one', 'two');
		$this->REQUIRE_TRUE('one' == 'one');
		$this->REQUIRE_FALSE('one' == 'two');
		
	}
	
	
	
	public function ExceptionTest() {
		
		$this->BEGIN_REQUIRE_EXCEPTION();

		//A statement between BEGIN_REQUIRE and
		//END_REQUIRE should throw an exception
		//in order to make the performed test 'passed'.
		
		divide(2, 0);
		
		$this->END_REQUIRE_EXCEPTION();
		
	}
	
	
}


?>