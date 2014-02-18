<?php
/*
PlaysMatchInTeam Class
*/


/**
@brief PlaysMatchInTeam Class

The class contains the following information:
- id
- playerId
- teamId
- matchId
- number
*/
class PlaysMatchInTeam {
	private $id;
	private $playerId;
	private $teamId;
	private $matchId;
	private $number;

	/**
	Constructor
	@param id
	*/
	public function __construct($id) {
		$this->id = $id;
	}

	/**
	Get the ID of the coach
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
		return "ID: $this->id";
	}

}
