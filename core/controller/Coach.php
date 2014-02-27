<?php
/*
Coach Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Coach extends Controller {

		public $page = 'coach';
	
	
		public function __construct() {
			$this->theme = 'coach.php';
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
