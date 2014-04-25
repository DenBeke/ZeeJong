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

	// A map on the matchid with the money players lost on that map
	private $matchesMoneyLost;

	public function __construct() {
		$this -> d = new Database();
		$this -> betList = $this -> d -> getUnhandledBets();
		$this -> betsToProcess = array();
		$this -> matchesMoneyLost = array();
	}

	public function genBetsToProcess() {
		foreach ($this->betList as $betId) {
			$bet = new Bet($betId, $this -> d);
			$match = $this -> d -> getMatchById($bet -> getMatchId());
			//if ($match -> getDate() < strtotime(date('d M Y', time()))){
			if (True == True) {// Just to process all unprocessed bets, only used for debug
				// Match was played, add bet to list of betsToProcess
				array_push($this -> betsToProcess, $bet);
			}
		}
	}

	public function processBets() {
		foreach ($this->betsToProcess as $bet) {
			$match = $this -> d -> getMatchById($bet -> getMatchId());
			//$totalMoney = $match->getTotalMoneyBetOn();
			if ($bet -> getScoreA() != $match -> getScore() -> getScoreA()) {
				// score A was not guessed correctly
				// Add match + the money the player lost to matches
				if (!isset($this -> matchesMoneyLost[$match -> getId()])) {
					$this -> matchesMoneyLost[$match -> getId()] = 0;
				}
				$this -> matchesMoneyLost[$match -> getId()] = $this -> matchesMoneyLost[$match -> getId()] + $bet -> getMoney() / 2;
			}
			if ($bet -> getScoreB() != $match -> getScore() -> getScoreB()) {
				// score B was not guessed correctly
				// Add match + the money the player lost to matches
				if (!isset($this -> matchesMoneyLost[$match -> getId()])) {
					$this -> matchesMoneyLost[$match -> getId()] = 0;
				}
				$this -> matchesMoneyLost[$match -> getId()] = $this -> matchesMoneyLost[$match -> getId()] + $bet -> getMoney() / 2;
			}

		}
		echo print_r($this->matchesMoneyLost);

	}

}

$betHandler = new BetHandler;
$betHandler -> genBetsToProcess();
$betHandler -> processBets();
?>

