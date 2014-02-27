<?php
/*
Competition Class
*/


/**
@brief Competition Class

The class contains the following information:
- id
- name
*/
class Competition {
	private $id;
	private $name;
	private $db;

	/**
	Constructor
	@param id
	*/
	public function __construct($id, $name, &$db) {
		$this->id = $id;
		$this->name = $name;
		$this->db = &$db;
	}

	/**
	Get the ID of the competition
	@return id
	*/
	public function getId() {
		return $this->id;
	}
	
	
	/**
	Get the name of the competition
	@return name
	*/
	public function getName() {
		//TODO Fetch name from database. (need to add function in Database.php)
		//return $this->db->getTournamentName($this->id);
		return $this->name;
	}
	
	
	
	/**
	Returns all tournaments of the competition
	
	@return tournaments
	*/
	public function getTournaments() {
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