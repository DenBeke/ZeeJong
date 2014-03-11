<?php
/*
 placeBet Controller

 Created March 2014
 */

namespace Controller {
	require_once (dirname(__FILE__) . '/../database.php');
	// Require the database file
	require_once (dirname(__FILE__) . '/Controller.php');

	class placeBet extends Controller {

		public $page = 'placeBet';
		private $template = 'placeBet.php';
		public $bet;
		
		/**
		 Render the template part of the view

		 @exception theme file does not exist
		 */
		public function template() {

			if (is_array($this -> data)) {
				extract($this -> data);
			}

			if (file_exists($this -> themeDir . '/' . $this -> template)) {
				include ($this -> themeDir . '/' . $this -> template);
			}

		}

		public function __construct() {
			global $database;
			// Test if logged in
			if (!isset($_SESSION['userID']) ) {
				return;
			}
			if(!$database -> doesUserExist($_SESSION['userID'])){
				return;
			}

		}
		
		public function placeBet($matchId, $teamId,$amount){
			
		}


	}

}
?>
