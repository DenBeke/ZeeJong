<?php
/*
Admin Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class AdminDashboard extends Controller {

		public $page = 'admin-dashboard';
		public $coach;
		public $title;
		
		
		
		public $teams;
		public $coaches;
		public $referees;
		public $players;
		
		public $competitions;
		public $tournaments;
		public $matches;
		
		public $bets;
		public $users;
		public $groups;
		
		public $cards;
		public $yellowCards;
		public $redCards;
		public $yellowTwoCards;


		public function __construct() {
			$this->theme = 'admin-dashboard.php';
			$this->title = 'Admin - Dashboard - ' . Controller::siteName;
			
			global $database;
			
			$this->teams = $database->countTeams();
			$this->coaches = $database->countCoaches();
			$this->referees = $database->countReferees();
			$this->players = $database->countPlayers();
			
			$this->competitions = $database->countCompetitions();
			$this->tournaments = $database->countTournaments();
			$this->matches = $database->countMatches();
			
			$this->users = $database->countUsers();
			$this->bets = $database->countBets();
			$this->groups = $database->countGroups();
			
			$this->cards = $database->countCards();
			$this->yellowCards = $database->countYellowCards();
			$this->redCards = $database->countRedCards();
			$this->yellowTwoCards = $database->countYellowTwoCards();
			
			
		}
		
		
		public function getTotalMatchesStats() {
		
		    global $database;
		
		    $months = getAllMonths($database->getFirstMatchDate());
		    $matches = [];

		    $count = 1;
		    foreach ($months as $month => $timestamp) {
			    if($count < sizeof($months)) {
				    $matches[$timestamp] = $database->getTotalNumberOfMatchesInInterval(array_values($months)[$count-1], array_values($months)[$count]);
			    }
			    $count++;
		    }
		    
		    return ['Matches' => $matches];
		}

	}

}

?>
