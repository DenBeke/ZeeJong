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
	private $firstName;
	private $lastName;
	private $country;

	/**
	Constructor
	@param id
	*/
	public function __construct($id, $firstName, $lastName, $country) {
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->country = $country;
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
		return $this->firstName . ' ' . $this->lastName;
	}

	/**
	Get the first name of the player
	@return First name
	*/
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	Get the last name of the player
	@return Last name
	*/
	public function getLastName() {
		return $this->lastName;
	}

	/**
	Get the country of the player
	@return The country
	*/
	public function getCountry() {
		return $this->country;
	}

	/**
	String function
	@return string
	*/
	public function __toString() {
		return "ID: $this->id";
	}

}
