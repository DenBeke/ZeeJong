<?php


/**
@brief Class containing the score

The class contains the following information:
	-id
	-match date
	-team A
	-team B
	-the id of the corresponding match
*/

class Score {


	private $id;
	private $matchDate;
	private $teamA;
	private $teamB;
	private $matchId;

	/**
	Constructor

	@param id The ID of the score
	*/
	public function __construct($id) {

		$this->id = $id;
		/*$this->matchDate = $matchDate;
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
        $output = "";
        $output = $output . "$this->teamA";
        $output = $output . " - ";
        $output = $output . "$this->teamB";
        return $output;
    }
}

?>