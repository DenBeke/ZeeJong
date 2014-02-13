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
	String function
	@return string
	*/
	public function __toString() {
		return "ID: $this->id";
	}

}
