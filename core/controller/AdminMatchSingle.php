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
			
				case "edit-meta":
				case "edit-meta/":
					$this->editMeta();
					break;
				
				case "add-goal":
				case "add-goal/":
					$this->addGoal();
					break;
					
				case "delete-goal":
				case "delete-goal/":
					$this->deleteGoal($args[3]);
					break;
					
				case "add-card":
				case "add-card/":
					$this->addCard();
					break;
					
				case "delete-card":
				case "delete-card/":
					$this->deleteCard($args[3]);
					break;
					
				case "add-player":
				case "add-player/":
					$this->addPlayer();
					break;
					
				case "delete-player":
				case "delete-player/":
					$this->deletePlayer($args[3]);
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
		
		
		private function deleteGoal($id) {
			
			global $database;
			$database->deleteGoal($id);
			
			//Refresh goals
			$this->goals = $database->getGoalsInMatch($this->match->getId());
			
		}
		
		
		private function deleteCard($id) {
			
			global $database;
			$database->deleteFoulCard($id);
			
			//Refresh cards
			$this->cards = $database->getCardsInMatch($this->match->getId());
			
		}
		
		
		
		private function addPlayer() {
			
			if(!isset($_POST['player-list'])) {
				throw new \exception('No player id given');
			}
			
			if(!isset($_POST['team-id'])) {
				throw new \exception('No team-id given');
			}
			
			if(!isset($_POST['number'])) {
				$number = -1;
			}
			else {
				$number = $_POST['number'];
			}
			
			global $database;
			$database->addPlayerToMatch($_POST['player-list'], $this->match->getId(), $_POST['team-id'], $number);
			
			//Refresh match
			$this->match = $database->getMatchById($this->match->getId());	
		}
		
		
		private function deletePlayer($playerId) {
			
			global $database;
			$database->removePlayerFromMatch($playerId, $this->match->getId()); 
			
			//Refresh match
			$this->match = $database->getMatchById($this->match->getId());	
		}
		
		
		private function editMeta() {
			
			global $database;
			
			if(isset($_POST['date'])) {
				$database->changeMatchDate($this->match->getId(), strtotime($_POST['date']));
			}
			if(isset($_POST['score'])) {
				
				$scoreRaw = explode('-', $_POST['score']);
				if(count($scoreRaw) === 2) {
					$database->changeMatchScore($this->match->getId(), $scoreRaw[0], $scoreRaw[1]);
				}
			}
			
			//Refresh match
			$this->match = $database->getMatchById($this->match->getId());
		}
		
		


	}

}

?>
