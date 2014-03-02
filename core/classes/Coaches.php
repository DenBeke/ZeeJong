<?php
/*
Coaches Class
*/


/**
@brief Coaches Class

The class contains the following information:
- id
- teamId
- coachId
- date
*/
class Coaches {
	private $id;
	private $teamId;
	private $coachId;
	private $date;

	/**
	Constructor
	@param id
	*/
	public function __construct($id, $teamId, $coachId, $date) {
		$this->id = $id;
		$this->teamId = $teamId;
		$this->coachId = $coachId;
		$this->date = $date;
	}

	/**
	Get the ID of the coaches relation
	@return id
	*/
	public function getId() {
		return $this->id;
	}

	/**
	Get the ID of the coach
	@return coachId
	*/
	public function getCoach() {
		return $this->coachId;
	}

	/**
	Get the ID of the team
	@return teamId
	*/
	public function getTeam() {
		return $this->teamId;
	}


	/**
	String function
	@return string
	*/
	public function __toString() {
		return "ID: $this->id";
	}

}
?>