<?php
/*
Match Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Match extends Controller {
	
		public $page = 'match';
	
		public function __construct() {
			$this->theme = 'match.php';
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
