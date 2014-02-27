<?php
/*
Referee Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Referee extends Controller {
	
		public $page = 'referee';
	
		public function __construct() {
			$this->theme = 'referee.php';
		}
		
		
		/**
		Call GET methode with parameters
		
		@param params
		*/
		public function GET($args) {
		}
	
	
	}

}

?>
