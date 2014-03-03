<?php
/*
Tournament Class
*/


/**
@brief Tournament Class

The class contains the following information:
- id
- name
*/
class Tournament {
	private $id;
	private $name;
	private $competitionId;
	private $db;

	/**
	Constructor
	@param id
	*/
	public function __construct($id, $name, $competitionId, &$db) {
		$this->id = $id;
		$this->name = $name;
		$this->competitionId = $competitionId;
		$this->db = &$db;
	}

	/**
	Get the ID of the tournament
	@return id
	*/
	public function getId() {
		return $this->id;
	}


	/**
	Get the name of the tournament
	@return name
	*/
	public function getName() {
		return $this->name;
	}


	/**
	Get The competition in which this tournament is held
	@return Competition
	*/
	public function getCompetition() {
		return $this->db->getCompetitionById($this->competitionId);
	}

	/**
	Get The id of the competition in which this tournament is held
	@return Competition id
	*/
	public function getCompetitionId() {
		return $this->competitionId;
	}




	/**
	Get the latest matches in the given tournament
	
	@param number of latest matches (0 for all matches)
	@return matches
	*/
	public function getMatches($number) {
		return $this->db->getMatchesInTournament($this->id);
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