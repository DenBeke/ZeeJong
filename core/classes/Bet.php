<?php


/**
@brief Class containing a bet

The class contains the following information:
	-id 
 	-matchId
 	-teamId
 	-time
 	-userId
*/

class Bet {
	private $db;
	private $id;

	/**
	Constructor

	@param id The ID of the bet
	*/
	public function __construct($id, &$db) {
		$this->db = &$db;
		$this->id = $id;

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