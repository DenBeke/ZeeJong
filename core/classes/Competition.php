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

	/**
	Constructor
	@param id
	*/
	public function __construct($id) {
		$this->id = $id;
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
	}
	
	
	
	/**
	Returns all tournaments of the competition
	
	@return tournaments
	*/
	public function getTournaments() {
		//TODO
		return array();
	}
	

	/**
	String function
	@return string
	*/
	public function __toString() {
		return "ID: $this->id";
	}

}
