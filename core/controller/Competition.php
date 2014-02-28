<?php
/*
Competition Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Competition extends Controller {
	
		public $page = 'competition';
	
	
		public function __construct() {
			$this->theme = 'competition.php';
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
