<?php
/*
 Bets Controller

 Created March 2014
 */

namespace Controller {
	require_once (dirname(__FILE__) . '/../database.php');
	// Require the database file
	require_once (dirname(__FILE__) . '/Controller.php');

	class Bets extends Controller {

		public $page = 'bets';
		private $template = 'bets.php';
		public $bet;
		public $title;
		private $unhandledbets;
		private $handledbets;

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
		    $this->title = 'Bets - ' . Controller::siteName;

			global $database;
			// Test if logged in
			if (!isset($_SESSION['userID']) ) {
				return;
			}
			if(!$database -> doesUserExist($_SESSION['userID'])){
				return;
			}
			global $database;
			$this->unhandledbets = $database -> getUserUnhandledBets($_SESSION['userID']);
			$this->handledbets = $database -> getUserHandledBets($_SESSION['userID']);
		}

		/*
		 Get an array consisting of the handled bet ID's

		 @return an array with the handled bet ID's for the current user
		 */
		public function getHandledBets() {
			return $this->handledbets;
		}
		
		/*
		 Get an array consisting of the unhandled bet ID's

		 @return an array with the unhandled bet ID's for the current user
		 */
		public function getUnhandledBets() {
			return $this->unhandledbets;
		}
		

/*
		
		 Get the amount of bets the user made

		 @return an int representing the amount of bets
		 
		public function getAmountOfBets() {
			return count($this -> getBets());
		}
*/
	}

}
?>
