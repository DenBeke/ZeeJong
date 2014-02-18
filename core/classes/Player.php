<?php
/*
Player Class
*/


/**
@brief Player Class

The class contains the following information:
- id
- name
- country
*/
class Player {
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
	Get the ID of the player
	@return id
	*/
	public function getId() {
		return $this->id;
	}

	/**
	Get the name of the player
	@return full name
	*/
	public function getName() {
		// TODO: Get the name from somewhere

		return "";
	}

	/**
	String function
	@return string
	*/
	public function __toString() {
		return "ID: $this->id";
	}

}
