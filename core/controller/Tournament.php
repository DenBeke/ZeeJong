<?php
/*
Tournament Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Tournament extends Controller {
	
		public $page = 'tournament';
	
		public function __construct() {
			$this->theme = 'tournament.php';
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
