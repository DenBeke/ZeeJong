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
	private $teamA;
	private $teamB;

	/**
	Constructor

	@param id The ID of the score
	*/
	public function __construct($id, $teamA, $teamB) {

		$this->id = $id;
		$this->teamA = $teamA;
		$this->teamB = $teamB;
	}

	/**
	Returns the id

	@return id
	*/
	public function getId() {

		return $this->id;
	}		



	public function getScoreA() {

		return $this->teamA;
	}


	public function getScoreB() {
	
		return $this->teamB;
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