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
			
			
			switch ($args[2]) {
			
				case "edit":
					break;
				
				case "add-goal":
				case "add-goal/":
					$this->addGoal();
					break;
					
				case "add-card":
				case "add-card/":
					$this->addCard();
					break;
					
			}
			
			
			$this->title = 'Admin - Match - ' . $this->match->getTeamA()->getName() . ' vs ' . $this->match->getTeamB()->getName() . ' - ' . Controller::siteName;

			
			
			
		}
		
		
		
		private function addGoal() {
			
			if(!isset($_POST['player-list'])) {
				throw new \exception('No player id given for goal');
			}
			
			if(!isset($_POST['time'])) {
				throw new \exception('No time given for goal');
			}
			
			global $database;
			$database->addGoal($_POST['player-list'], $_POST['time'], $this->match->getId());
			
			//Refresh goals
			$this->goals = $database->getGoalsInMatch($this->match->getId());
			
		}
		
		
		private function addCard() {
			
			if(!isset($_POST['player-list'])) {
				throw new \exception('No player id given for card');
			}
			
			if(!isset($_POST['time'])) {
				throw new \exception('No time given for card');
			}
			
			if(!isset($_POST['type'])) {
				throw new \exception('No type given for card');
			}
			
			global $database;
			$database->addFoulCard($_POST['player-list'], $this->match->getId(), $_POST['time'], $_POST['type']);
			
			//Refresh cards
			$this->cards = $database->getCardsInMatch($this->match->getId());
			
		}
		
		


	}

}

?>
