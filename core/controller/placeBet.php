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
		private $stop;
		public $title;

		public function __construct() {
			global $database;
			$this -> theme = 'placeBet.php';
			$this -> title = 'Place Bet - ' . Controller::siteName;
			$this -> stop = False;
			// Test if logged in
			if (!isset($_SESSION['userID']) || !isset($_POST['money']) || !isset($_POST['matchId'])) {
				return;
			}
			if (!$database -> doesUserExist($_SESSION['userID'])) {
				$this -> stop = True;
				return;
			}

			if (!$_POST['money'] > 0) {
				$this -> betErrorMessage = $this -> betErrorMessage . "You must bet for more than €0." . "\r\n";
				$this -> matchId = $_POST['matchId'];
			}

			if (!isset($_POST['score1']) && !isset($_POST['score2'])) {
				$this -> betErrorMessage = $this -> betErrorMessage . "You must bet for at least one parameter." . "\r\n";
				$this -> matchId = $_POST['matchId'];
				return;
			}
			if (strlen($this -> betErrorMessage) == 0) {
				// Safe to place bet
				$this -> placeBet();
			}
		}

		private function placeBet() {
			global $database;
			if ($database -> getMoney($_SESSION['userID']) < $_POST['money']) {
				$this -> betErrorMessage = $this -> betErrorMessage . "You do not have enough money." . "\r\n";
				return;
			}

			$score1 = -1;
			$score2 = -1;
			if (isset($_POST['score1'])) {
				if ($_POST['score1'] < 0) {
					$this -> betErrorMessage = $this -> betErrorMessage . "Scores can't be less than 0." . "\r\n";
					$this -> matchId = $_POST['matchId'];
					return;
				}
				$score1 = $_POST['score1'];
			}
			if (isset($_POST['score2'])) {
				if ($_POST['score2'] < 0) {
					$this -> betErrorMessage = $this -> betErrorMessage . "Scores can't be less than 0." . "\r\n";
					$this -> matchId = $_POST['matchId'];
					return;
				}
				$score2 = $_POST['score2'];
			}

			$database -> addBet($_POST['matchId'], $score1, $score2, $_SESSION['userID'], $_POST['money']);
			$database -> setMoney($_SESSION['userID'], $database -> getMoney($_SESSION['userID']) - $_POST['money']);
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
				$this -> stop = True;
				return;
			} else {
				$this -> stop = False;
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

		/**
		 Is bet within time fram

		 @return boolean whether match is already over
		 */
		public function matchOver($id) {
			global $database;
			if (!$database -> doesMatchExist($id)) {
				return True;
			}
			$match = $database -> getMatchById($id);
			if ($match -> getDate() < strtotime(date('d M Y', time())))
				$this -> betErrorMessage = $this -> betErrorMessage . "You cannot place a bet for a match which is already played." . "\r\n";
			return $match -> getDate() < strtotime(date('d M Y', time()));
		}

		/**
		 Can we continue?

		 @return a boolean indicating whether it's safe to continue
		 */
		public function stop() {
			if (isset($_POST['matchId'])) {
				$this -> matchId = $_POST['matchId'];
			}
			return $this -> stop || $this -> matchOver($this -> matchId);
		}

	}

}
?>
