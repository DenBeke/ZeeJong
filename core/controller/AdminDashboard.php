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
			
			
		}

	}

}

?>
