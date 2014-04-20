<?php
/*
Match Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Match extends Controller {

		public $page = 'match';
		public $match;
		public $goals;
		public $title;


		public function __construct() {
			$this->theme = 'match.php';
			$this->title = 'Match - ' . Controller::siteName;
		}


		/**
		Call GET methode with parameters

		@param params
		*/
		public function GET($args) {
			if(!isset($args[1])) {
				throw new \exception('No match id given');
				return;
			}

			global $database;
			$this->match = $database->getMatchById($args[1]);
			$this->goals = $database->getGoalsInMatch($this->match->getId());

			$this->title = 'Match - ' . $this->match->getTeamA()->getName() . ' vs ' . $this->match->getTeamB()->getName() . ' - ' . Controller::siteName;
		}


	}

}

?>
