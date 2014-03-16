<?php
/*
Home Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Home extends Controller {
	
		public $page = 'home';
		public $events;
		public $players;
	
		public function __construct() {
			global $database;
			$this->theme = 'home.php';
			$this->events = $database->getUpcommingEvents(5);
			$this->players = $database->getPlayersWithMostMatches(0,6);
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