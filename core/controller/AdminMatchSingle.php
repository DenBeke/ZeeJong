<?php
/*
Admin Match Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class AdminMatch extends Controller {

		public $page = 'admin-match';
		public $title;
		public $match;
		public $goals;
		public $cards;
		public $totalBet;

		public function __construct() {
			$this->theme = 'admin-match.php';
			$this->title = 'Admin - Match - ' . Controller::siteName;
		}


		/**
		Call GET methode with parameters

		@param params
		*/
		public function GET($args) {

			if(!isset($args[1])) {
				throw new \exception('No match id given');
			}
			if(!isset($args[2])) {
				throw new \exception('No action given');
			}			
			
			global $database;
			$this->match = $database->getMatchById($args[1]);
			$this->goals = $database->getGoalsInMatch($this->match->getId());
			$this->cards = $database->getCardsInMatch($this->match->getId());
			$this->totalBet = $database->getAmountBetOnMatch($this->match->getId());
			
			$this->title = 'Admin - Match - ' . $this->match->getTeamA()->getName() . ' vs ' . $this->match->getTeamB()->getName() . ' - ' . Controller::siteName;

			
			
			
		}


	}

}

?>
