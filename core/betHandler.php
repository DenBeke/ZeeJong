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

    // A counter with how many bets were processed
    private $betsProcessed;

    // A counter with the amount of money that was distributed to the winners
    private $moneyDistributed;

    // A counter with the amount of parameters that was bet on
    private $parametersBetOn;

    // A counter with the amount of money that was lost on all bets processed
    private $moneyLostInTotal;

    /**
     * Constructor of the betHandler class
     */
    public function __construct() {
        $this -> d = new Database();
        $this -> betList = $this -> d -> getUnhandledBets();
        $this -> betsToProcess = array();
        $this -> matchesMoneyLost = array();
        $this -> betsProcessed = 0;
        $this -> moneyDistributed = 0;
        $this -> parametersBetOn = 0;
    }

    /**
     * Generate a list of bets to process
     */
    public function genBetsToProcess() {
        foreach ($this->betList as $betId) {
            $bet = new Bet($betId);
            $match = $this -> d -> getMatchById($bet -> getMatchId());
            if ($match -> getScoreId() != NULL) {// Referee ID is -1 as long as score etc is not added to match
                // Match was played, add bet to list of betsToProcess
                array_push($this -> betsToProcess, $bet);
            }
        }
    }

    /**
     * Add the money lost for a certain bet on a certain match
     */
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
        $this -> moneyDistributed = $this -> moneyDistributed + $bet -> getMoney() / $bet -> howManyItemsBet();
        // Add the money won
        if (isset($this -> matchesMoneyLost[$match -> getId()])) {
            $user -> addMoney(($bet -> getMoney() * ($this -> matchesMoneyLost[$match -> getId()] / ($match -> getTotalMoneyBetOn() - $this -> matchesMoneyLost[$match -> getId()]))) / $bet -> howManyItemsBet());
            $user -> addMoneyWon(($bet -> getMoney() * ($this -> matchesMoneyLost[$match -> getId()] / ($match -> getTotalMoneyBetOn() - $this -> matchesMoneyLost[$match -> getId()]))) / $bet -> howManyItemsBet());
            $this -> moneyDistributed = $this -> moneyDistributed + ($bet -> getMoney() * ($this -> matchesMoneyLost[$match -> getId()] / ($match -> getTotalMoneyBetOn() - $this -> matchesMoneyLost[$match -> getId()]))) / $bet -> howManyItemsBet();
        }
    }

    /**
     * Process the list of unhandled bets (which can be handled now)
     */
    public function processBets() {
        foreach ($this->betsToProcess as $bet) {
            $match = $this -> d -> getMatchById($bet -> getMatchId());
            $this -> parametersBetOn = $this -> parametersBetOn + $bet -> howManyItemsBet();
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
            $this -> betsProcessed = $this -> betsProcessed + 1;
        }

    }

    /**
     * Get the amount of bets processed
     */
    public function getBetsProcessed() {
        return $this -> betsProcessed;
    }

    /**
     * Get the total amount of money distributed
     */
    public function getMoneyDistributed() {
        return $this -> moneyDistributed;
    }

    /**
     * Get the total amount of parameters bet on
     */
    public function getParametersBetOn() {
        return $this -> parametersBetOn;
    }

}
?>