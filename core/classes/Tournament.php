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

	/**
	Constructor
	@param id
	*/
	public function __construct($id) {
		$this->id = $id;
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
	Get the latest matches in the given tournament
	
	@param number of latest matches (0 for all matches)
	@return matches
	*/
	public function getMatches($number) {
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
?>