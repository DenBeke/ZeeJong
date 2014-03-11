<?php
/*
PHP Unit Tes framework data structures

Author: Mathias Beke
Url: http://denbeke.be
Date: March 2014
*/

namespace UnitTest;


/**
@brief Datastructure for a scenario of tests
*/
class Scenario {
	public $numberOfTest = 0;
	public $numberOfFailures = 0;
	public $tests = array();
}



/**
@brief Datastructure for a test case
*/
class TestCase {

	public $name;
	public $sections = array();

}


/**
@brief Datastructure for a section of individual tests
*/
class TestSection {

	public $name;
	public $tests = array();
	public $success = true;

}


?>