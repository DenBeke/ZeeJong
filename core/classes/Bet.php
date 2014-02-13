<?php


/**
@brief Class containing a bet

The class contains the following information:
	-id
	-match date
	-team A
	-team B
	-the id of the corresponding match
*/

class Bet {


	private $id;
	private $betDate;
	private $teamA;
	private $teamB;
	private $matchId;
	private $amount;
	private $userId;

	/**
	Constructor

	@param id The ID of the bet
	*/
	public function __construct($id) {

		$this->id = $id;
		/*$this->betDate = $matchDate;
		$this->teamA = $teamA;
		$this->teamB = $teamB;
		$this->matchId = $matchId;*/
	}

	/**
	Returns the id

	@return id
	*/
	public function getId() {

		return $this->id;
	}

    /**
    String function

    @return string
    */
    public function __toString() {
        $output = "ID: $this->id";
        /*$output = $output . "$this->teamA";
        $output = $output . " - ";
        $output = $output . "$this->teamB";*/
        return $output;
    }
}

?>