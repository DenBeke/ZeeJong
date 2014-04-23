<?php
/*
Team Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Team extends Controller {

		public $page = 'team';
		public $team;
		public $title;


		public function __construct() {
			$this->theme = 'team.php';
			$this->title = 'Team - ' . Controller::siteName;
		}


		/**
		Call GET methode with parameters

		@param params
		*/
		public function GET($args) {

			if(!isset($args[1])) {
				throw new \exception('No team id given');
				return;
			}

			global $database;
			$this->team = $database->getTeamById($args[1]);

			$this->title = 'Team - ' . $this->team->getName() . ' - ' . Controller::siteName;
		}


	}

}

?>
