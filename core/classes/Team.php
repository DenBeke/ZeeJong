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
	private $country;
	private $db;

	/**
	Constructor
	@param id
	*/
	public function __construct($id, $name, $country, &$db) {
		$this->id = $id;
		$this->name = $name;
		$this->country = $country;
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
		return $this->country;
	}
	
	
	public function getPlayers() {
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