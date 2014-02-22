<?php
/*
Coaches Class
*/


/**
@brief Coaches Class

The class contains the following information:
- id
- teamId
- coachId
- date
*/
class Coaches {
	private $id;
	private $teamId;
	private $coachId;
	private $date;

	/**
	Constructor
	@param id
	*/
	public function __construct($id) {
		$this->id = $id;
	}

	/**
	Get the ID of the coach
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
?>