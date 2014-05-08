<?php
/*
Header Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Header extends Controller {

	
		public $competitions;
		public $userGroups;
		public $money;
		public $score;
		
		
	
		public function __construct() {
			global $database;
			$this->competitions = $database->getAllCompetitions();
			
			if(loggedIn()) {
			
				$this->userGroups = $database->getUserGroups($_SESSION['userID']);
				
				$this->userGroupNames = array();
				
				foreach($this->userGroups as $groupId){
					$this->userGroupNames[$groupId] = $database->getGroupName($groupId);
				}
				
				
				$this->money = $database->getMoney($_SESSION['userID']);
				
				$user = new \User($_SESSION['userID']);
				$this->score = number_format((float)$user->getScore(),2,'.','.');
			
			}
		}
		


	}

}

?>
