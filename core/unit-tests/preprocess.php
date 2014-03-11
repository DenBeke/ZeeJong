<?php
/*
Preprocesser for Unit Testing Framework

Author: Mathias Beke
Url: http://denbeke.be
Date: March 2014
*/


function preprocess($dir = '/tests/', $preprocessed_dir = 'preprocessed/') {


	foreach (glob(dirname(__FILE__) . $dir . '*.php') as $file) {
	
	
		$lines = file($file);
	
	
		$output = '';
	
		foreach ($lines as $line) {
	
			if(preg_match('/.*BEGIN_REQUIRE_EXCEPTION.*/i', $line)) {
				$output = $output . $line;
				$output = $output . "try {";
			}
			elseif(preg_match('/.*END_REQUIRE_EXCEPTION.*/i', $line)) {
				$output = $output . '$this->NOEXCEPT();' . "";
				$output = $output . "} ";
				$output = $output . "catch(\\Exception  " . '$e' .") {";
				$output = $output . '$this->EXCEPT();' . "";
				$output = $output . "}";
			}
			else {
				$output = $output . $line;
			}
	
		}
	
	
	
		//Get class name without namespace in front of it
		$file = explode('/', $file);
		$file[sizeof($file)-1] = $preprocessed_dir . $file[sizeof($file)-1];
		$file = implode('/', $file);
	
		file_put_contents($file, $output);
	
	
	}
	
}

?>