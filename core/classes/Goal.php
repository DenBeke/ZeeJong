<?php
/*
Goal Class
*/


/**
@brief Goal Class

The class contains the following information:
- id
- time
*/
class Goal {
	private $id;
	private $time;

	/**
	Constructor
	@param id
	*/
	public function __construct($id) {
		$this->id = $id;
	}

	/**
	Get the ID of the goal
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