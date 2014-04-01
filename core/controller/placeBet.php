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

		private $bet;
		private $betSuccessMessage;
		private $betErrorMessage;
		private $matchId;
		public $title;


		public function __construct() {
			global $database;
			$this -> theme = 'placeBet.php';
			$this->title = 'Place Bet - ' . Controller::siteName;

			// Test if logged in
			if (!isset($_SESSION['userID']) || !isset($_POST['score1']) || !isset($_POST['score2']) || !isset($_POST['money']) || !isset($_POST['matchId'])) {
				return;
			}
			if (!$database -> doesUserExist($_SESSION['userID'])) {
				return;
			}
			if (!$_POST['money'] > 0) {
				$this -> betErrorMessage = $this -> betErrorMessage . "You must bet for more than €0." . "\r\n";
				$this -> matchId = $_POST['matchId'];
			}
			if ($_POST['score1'] < 0 || $_POST['score2'] < 0) {
				$this -> betErrorMessage = $this -> betErrorMessage . "Scores can't be less than 0." . "\r\n";
				$this -> matchId = $_POST['matchId'];
			}
			if (strlen($this -> betErrorMessage) == 0) {
				// Safe to place bet
				$this -> placeBet();
			}
		}

		private function placeBet() {
			global $database;
			$database -> addBet($_POST['matchId'], $_POST['score1'], $_POST['score2'], $_SESSION['userID'], $_POST['money']);
			$this -> betSuccessMessage = $this -> betSuccessMessage . "Bet was successfully placed." . "\r\n";
		}

		/**
		 Call GET methode with parameters

		 @param params
		 */
		public function GET($args) {
			if (!isset($args[1])) {
				throw new \exception('No match id given');
				return;
			}
			$this -> args = $args[1];
			global $database;
			if (!$database -> doesMatchExist($args[1])) {
				$this -> betErrorMessage = $this -> betErrorMessage . "Match does not exist." . "\r\n";
				return;
			}
			$this -> matchId = $args[1];
		}

		/**
		 Get the error message
		 @return the error message (if one exists)
		 */
		public function getErrorMessage() {
			return $this -> betErrorMessage;
		}

		/**
		 Get the success message
		 @return the success message (if one exists)
		 */
		public function getSuccessMessage() {
			return $this -> betSuccessMessage;
		}

		/**
		 Get the match
		 @return the match object
		 */
		public function getMatchId() {
			return $this -> matchId;
		}

	}

}
?>
