<?php
/*
Home Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Home extends Controller {
	
		public $page = 'home';
	
		public function __construct() {
			$this->theme = 'home.php';
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