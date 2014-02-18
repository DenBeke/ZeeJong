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

	/**
	Constructor
	@param id
	*/
	public function __construct($id) {
		$this->id = $id;
	}

	/**
	Get the ID of the team
	@return id
	*/
	public function getId() {
		return $this->id;
	}


	public function getName() {
		
	}


	/**
	String function
	@return string
	*/
	public function __toString() {
		return "ID: $this->id";
	}

}
