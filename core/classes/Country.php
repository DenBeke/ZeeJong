<?php
/*
Country Class
*/

class Country {
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
	Get the ID of the country
	@return id
	*/
	public function getId() {
		return $this->id;
	}

	/**
	Get the name of the country
	@return The name
	*/
	public function getName() {
		// TODO: Get name from somewhere

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
