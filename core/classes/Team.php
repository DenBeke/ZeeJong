<?php
/*
Team Class
*/


/**
@brief Team Class

The class contains the following information:
- id
- name
- country
*/
class Team {
	private $id;
	private $name;
	private $countryId;
	private $db;

	/**
	Constructor
	@param id
	*/
	public function __construct($id, $name, $countryId, &$db) {
		$this->id = $id;
		$this->name = $name;
		$this->countryId = $countryId;
		$this->db = &$db;
	}

	/**
	Get the ID of the team
	@return id
	*/
	public function getId() {
		return $this->id;
	}


	public function getName() {
		return $this->name;		
	}

	public function getCountry() {
		return $this->db->getCountryById($this->countryId);
	}


	public function getCountryId() {
		return $this->countryId;
	}
	
	
	public function getPlayers() {
		return $this->db->getPlayersInTeam($this->id);
	}
	
	
	public function getCoach() {
		return $this->db->getCoachForTeam($this->id);
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