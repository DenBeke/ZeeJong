<?php
/*
Referee Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Referee extends Controller {
	
		public $page = 'referee';
		public $referee;
	
		public function __construct() {
			$this->theme = 'referee.php';
		}
		
		
		/**
		Call GET methode with parameters
		
		@param params
		*/
		public function GET($args) {
		
			if(!isset($args[1])) {
				throw new \exception('No referee id given');
				return;
			}
			
			global $database;
			$this->referee = $database->getRefereeById($args[1]);
		
		}
	
	
	}

}

?>
