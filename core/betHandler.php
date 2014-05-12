<?php
/*
 Bet handler

 Loops through all bets and checks when a match is played
 If so, then it is checked whether the bet was correct.
 Created: April 2014
 */

date_default_timezone_set('Europe/Brussels');

require_once (dirname(__FILE__) . '/database.php');
require_once (dirname(__FILE__) . '/classes/Bet.php');
require_once (dirname(__FILE__) . '/classes/Match.php');
require_once (dirname(__FILE__) . '/classes/User.php');
require_once (dirname(__FILE__) . '/classes/Score.php');

/*
 * BetHandler class
 */
class BetHandler {

	// Database
	private $d;

	// List with ID's
	private $betList;

	// List with bet OBJECTS
	private $betsToProcess;

	// A map on the matchid with the money users lost on that match
	private $matchesMoneyLost;

	public function __construct() {
		$this -> d = new Database();
		$this -> betList = $this -> d -> getUnhandledBets();
		$this -> betsToProcess = array();
		$this -> matchesMoneyLost = array();
	}

	public function genBetsToProcess() {
		foreach ($this->betList as $betId) {
			$bet = new Bet($betId);
			$match = $this -> d -> getMatchById($bet -> getMatchId());
			if ($match -> getRefereeId() != -1) {// Referee ID is -1 as long as score etc is not added to match
				// Match was played, add bet to list of betsToProcess
				array_push($this -> betsToProcess, $bet);
			}
		}
	}

	private function addMoneyLost($bet, $match) {
		if (!isset($this -> matchesMoneyLost[$match -> getId()])) {
			$this -> matchesMoneyLost[$match -> getId()] = 0;
		}
		$this -> matchesMoneyLost[$match -> getId()] = $this -> matchesMoneyLost[$match -> getId()] + $bet -> getMoney() / $bet -> howManyItemsBet();
	}

	private function reward($bet, $user, $match) {
		// Add bet money itself
		$user -> addMoney($bet -> getMoney() / $bet -> howManyItemsBet());
		$user -> addMoneyWon($bet -> getMoney() / $bet -> howManyItemsBet());
		// Add the money won
		if (isset($this -> matchesMoneyLost[$match -> getId()])) {
			$user -> addMoney(($bet -> getMoney() * ($this -> matchesMoneyLost[$match -> getId()] / ($match -> getTotalMoneyBetOn() - $this -> matchesMoneyLost[$match -> getId()]))) / $bet -> howManyItemsBet());
			$user -> addMoneyWon(($bet -> getMoney() * ($this -> matchesMoneyLost[$match -> getId()] / ($match -> getTotalMoneyBetOn() - $this -> matchesMoneyLost[$match -> getId()]))) / $bet -> howManyItemsBet());
		}
	}

	public function processBets() {
		foreach ($this->betsToProcess as $bet) {
			$match = $this -> d -> getMatchById($bet -> getMatchId());
			if ($bet -> getScoreA() != $match -> getScore() -> getScoreA() && $bet -> getScoreA() != -1) {
				// score A was not guessed correctly
				$this -> addMoneyLost($bet, $match);
			}
			if ($bet -> getScoreB() != $match -> getScore() -> getScoreB() && $bet -> getScoreB() != -1) {
				// score B was not guessed correctly
				$this -> addMoneyLost($bet, $match);
			}

			if ($bet -> getFirstGoal() != $match -> getFirstScorer() -> getId() && $bet -> getFirstGoal() != -1) {
				// First scorer was not guessed correctly
				$this -> addMoneyLost($bet, $match);
			}

			if ($bet -> getRedCards() != $match -> getTotalRedCards() && $bet -> getRedCards() != -1) {
				// Amount of red cards was not guessed correctly
				$this -> addMoneyLost($bet, $match);
			}

			if ($bet -> getYellowCards() != $match -> getTotalYellowCards() && $bet -> getYellowCards() != -1) {
				// Amount of red cards was not guessed correctly
				$this -> addMoneyLost($bet, $match);
			}

		}
		// Now we have a mapped list (=array) with for each matchId the amount of money that can be divided over the winners... well.. what are we waiting for?
		// Let's iterate over the betsToProcess again and give the user money if he won...
		foreach ($this->betsToProcess as $bet) {
			$match = $this -> d -> getMatchById($bet -> getMatchId());
			$totalMoney = $match -> getTotalMoneyBetOn();
			$user = new User($bet -> getUserId());
			if ($bet -> getScoreA() == $match -> getScore() -> getScoreA()) {
				// Correctly guessed score A
				$this -> reward($bet, $user, $match);
			}
			if ($bet -> getScoreB() == $match -> getScore() -> getScoreB()) {
				// Correctly guessed score B
				$this -> reward($bet, $user, $match);
			}

			if ($bet -> getFirstGoal() == $match -> getFirstScorer() -> getId()) {
				// Correctly guessed the player who made the first goal
				$this -> reward($bet, $user, $match);
			}

			if ($bet -> getRedCards() == $match -> getTotalRedCards()) {
				// Correctly guessed the total amount of red cards
				$this -> reward($bet, $user, $match);
			}

			if ($bet -> getYellowCards() == $match -> getTotalYellowCards()) {
				// Correctly guessed the total amount of yellow cards
				$this -> reward($bet, $user, $match);
			}

			// Set bet handled
			$this -> d -> setBetHandled($bet -> getId());
		}

	}

}

$betHandler = new BetHandler;
$betHandler -> genBetsToProcess();
$betHandler -> processBets();
?>

