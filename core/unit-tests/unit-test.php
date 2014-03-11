<?php
/*
PHP Unit Tes framework

Author: Mathias Beke
Url: http://denbeke.be
Date: March 2014
*/

/**
@brief Unit Test namespace

All classes of tests you want to run, must be in this namespace.  
If not placed in this namespace, the tests will not be recognized.
*/
namespace UnitTest;



require_once( dirname(__FILE__) . '/objects.php' );


$scenario = new Scenario;



/**
@brief Class for performing unit tests

Unit tests are written using classes and function.
- Each class represents a test case
- Each function represents a test section
- Within this functions you can call the `REQUIRE` functions


    <?php
    
    namespace UnitTest;
    
    class StringTest extends UnitTest {
    
    
	    	public function Word() {
	    		$this->REQUIRE_TRUE('word', 'word');
	    	}
	    
	    	public function Sentence() {
	    		$var1 = 'hello world!';
	    		$var2 = 'hello world!';
	    		$this->REQUIRE_TRUE($var1, $var2);
	    	}
	}
	?>
    	


Execute the `run` function to perform all declared tests.

All performed tests will be placed in the `Scenario`,
which can be accessed in orde to view te test results.  
You can also output the test to html using the `write` function.
*/
class UnitTest {
	
	
	private $requireException = false;
	

	public function REQUIRE_EQUAL($a, $b) {
		
		
		$test = array();
		$test['a'] = $a;
		$test['b'] = $b;
		
		if($a == $b) {	
			$test['result'] = true;
		}
		else {
			$test['result'] = false;
		}
		
		$this->saveTest($test);
	
	}
	
	
	
	
	
	public function REQUIRE_NOTEQUAL($a, $b) {
	
		$test = array();
		$test['a'] = $a;
		$test['b'] = $b;
		
		if($a != $b) {
			$test['result'] = true;
		}
		else {
			$test['result'] = false;	
		}
		
		$this->saveTest($test);
	
	}
	
	
	
	public function REQUIRE_TRUE($a) {
	
		$test = array();
		$test['a'] = $a;
		
		if($a) {
			$test['result'] = true;
		}
		else {
			$test['result'] = false;
		}
		
		$this->saveTest($test);
	
	}
	
	
	
	
	public function REQUIRE_FALSE($a) {
	
		$test = array();
		$test['a'] = $a;
		
		if(!$a) {
			$test['result'] = true;
		}
		else {
			$test['result'] = false;
		}
		
		$this->saveTest($test);
	
	}
	
	
	
	
	public function BEGIN_REQUIRE_EXCEPTION() {
		
		$this->requireException = true;
		
	}
	
	public function EXCEPT($method = NULL) {
		
		if($this->requireException) {
			$test['result'] = true;
			$this->requireException = false;
		}
		else {
			$test['type'] = 'unexpected';
			$test['result'] = false;
		}
		$this->saveTest($test, $method);
		
	}
	
	
	public function NOEXCEPT() {
		
		if($this->requireException) {
			$test['result'] = false;
			$test['type'] = 'no_exception';
			$this->requireException = false;
		}
		else {
			$test['result'] = true;
		}
		$this->saveTest($test);
		
	}
	
	
	public function saveTest($test, $method = NULL) {
		
		
		global $scenario;
		$scenario->numberOfTest++;
		
		//Get the line from which the REQUIRE function is called
		$test['file'] = debug_backtrace()[1]['file'];
		$test['line'] = debug_backtrace()[1]['line'];
		
		//Get the method from which the REQUIRE function is called
		if($method == NULL) {
			$method = debug_backtrace()[3]['args'][0][1];
		}
		
		//Get class name without namespace in front of it
		$class = get_class($this);
		$class = explode('\\', $class);
		unset($class[0]);
		$class = implode('\\', $class);
		
		//Check if there is a test case with the given class name
		if(!isset($scenario->tests[$class])) {
			$case = new TestCase;
			$case->name = $class;
			$scenario->tests[$class] = $case;
		}
		
		//Check for the test section
		if(!isset($scenario->tests[$class]->sections[$method])) {
			$section = new TestSection;
			$section->name = $method;
			$scenario->tests[$class]->sections[$method] = $section;
		}
		else {
			$section  = $scenario->tests[$class]->sections[$method];
		}
		
		//On failure
		if($test['result'] == false) {
			
			//Count the number of failures
			$section->success= false;
			$scenario->numberOfFailures++;
		
					
			//Regular test case
			if(!isset($test['type'])) {
				//Get get the source line from the caller
				$lines = file($test['file']);
				$test['failed_line'] = $lines[$test['line']-1];
			}
			
			//In case of expected exception that was not thrown
			//We output the whole code block
			elseif(isset($test['type']) and $test['type'] == 'no_exception') {
				$file = explode('/', $test['file']);
				unset($file[sizeof($file)-2]);
				$file = implode('/', $file);
				$lines = file($file);
				$line = $test['line'];
				
				
				$startLine = $line;
				
				while(!preg_match('/.*BEGIN_REQUIRE_EXCEPTION.*/i', $lines[$startLine])) {
					$startLine--;
				}
				
				$test['failed_line'] = '';
				$test['line'] = $startLine+1;
				
				
				while($startLine != $line) {
					$test['failed_line'] = $test['failed_line'] . '<br>' . $lines[$startLine];
					$startLine++;
				}
			
			}
			else {
				$test['failed_line'] = "$class::$method {<br> ... <br>}";
			}
		
		}
		
		$section->tests[] = $test;
		
	}
	
	
	
	public function write() {
	
		global $scenario;
		include(dirname(__FILE__) . '/theme/content.php');
	
	}
	
	
	public function run() {
		
		
		//Cache class objects
		$objects = array();
		
		
		//Loop through all declared classes
		foreach (get_declared_classes() as $class) {
			
			//Check if class in 'UnitTest' namespace
			if(preg_match('/UnitTest\\.*/i', $class) and get_class($this) != $class) {
				
				//Loop through functions of that class
				foreach (get_class_methods($class) as $method) {
					
					
					//Don't run constructors
					if($method == '__construct') {
						continue;
					}
					
					//If not a method of this class, we call the function
					if(!in_array($method, get_class_methods(get_class($this)))) {
						
						//Check if object yet cached or not
						//Since we don't want to construct it every time
						if(!isset($objects[$class])) {
							$objects[$class] = new $class;
						}
						
						
						try {
							call_user_func(array($objects[$class], $method));
						}
						catch(\Exception $e) {
							//$test['result'] = false;
							$objects[$class]->EXCEPT($method);
						}
						
						
							
					}
				}
				
			} //end if
		
		} //end foreach	 
		
	} // end run()

}


