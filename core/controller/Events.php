<?php
/*
Events Controller

Created March 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Events extends Controller {

		public $page = 'events';
		public $events;
		public $title;

		public function __construct() {
			global $database;
			$this->theme = 'events.php';
			$this->events = $database->getUpcommingEvents(30);
			$this->title = 'Events - ' . Controller::siteName;
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
