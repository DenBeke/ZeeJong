<?php
/*
Coach Class
*/


/**
@brief Coach Class

The class contains the following information:
- id
- name
- country
*/
class Coach {
	private $id;
	private $firstName;
	private $lastName;
	private $country;


	/**
	Constructor
	@param id
	*/
	public function __construct($id, $firstName, $lastName, $country, &$db) {
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->country = $country;
		$this->db = &$db;
	}

	/**
	Get the ID of the coach
	@return id
	*/
	public function getId() {
		return $this->id;
	}

	/**
	Get the name of the coach
	@return full name
	*/
	public function getName() {
		return $this->firstName . ' ' . $this->lastName;
	}

	/**
	Get the first name of the coach
	@return First name
	*/
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	Get the last name of the coach
	@return Last name
	*/
	public function getLastName() {
		return $this->lastName;
	}

	/**
	Get the country of the coach
	@return The country
	*/
	public function getCountry() {
		return $this->db->getCountryById($this->country);
	}

	/**
	Get the country of the coach
	@return The country id
	*/
	public function getCountryId() {
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
?>
