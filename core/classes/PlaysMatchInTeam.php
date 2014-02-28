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
	public function __construct($id, $playerId, $teamId, $matchId, $number) {
		$this->id = $id;
		$this->playerId = $playerId;
		$this->teamId = $teamId;
		$this->matchId = $matchId;
		$this->number = $number;
	}

	/**
	Get the ID of the playsmatchinteam relation
	@return id
	*/
	public function getId() {
		return $this->id;
	}

	/**
	Get the player ID of the playsmatchinteam relation
	@return id
	*/
	public function getPlayer() {
		return $this->playerId;
	}

	/**
	Get the team ID of the playsmatchinteam relation
	@return id
	*/
	public function getTeam() {
		return $this->teamId;
	}

	/**
	Get the team ID of the playsmatchinteam relation
	@return id
	*/
	public function getMatch() {
		return $this->matchId;
	}

	/**
	Get the shirtnumber of the player in the match
	@return id
	*/
	public function getNumber() {
		return $this->number;
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