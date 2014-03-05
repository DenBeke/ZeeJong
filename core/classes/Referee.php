<?php
/*
Referee Class
*/


/**
@brief Referee Class

The class contains the following information:
- id
- name
- country
*/
class Referee {
	private $id;
	private $firstName;
	private $lastName;
	private $countryId;
	private $db;

	/**
	Constructor
	@param id
	*/
	public function __construct($id, $firstName, $lastName, $countryId, &$db) {
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->countryId = $countryId;
		$this->db = &$db;
	}

	/**
	Get the ID of the referee
	@return id
	*/
	public function getId() {
		return $this->id;
	}

	/**
	Get the name of the referee
	@return full name
	*/
	public function getName() {
		return $this->firstName . ' ' . $this->lastName;
	}

	/**
	Get the first name of the referee
	@return First name
	*/
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	Get the last name of the referee
	@return Last name
	*/
	public function getLastName() {
		return $this->lastName;
	}

	/**
	Get the country of the referee
	@return The country
	*/
	public function getCountry() {
		return $this->db->getCountryById($this->countryId);
	}


	/**
	Get the id of the country of the referee
	@return The country id
	*/
	public function getCountryId() {
		return $this->countryId;
	}
	
	
	
	public function getTotalMatches() {
	}
	
	
	public function getTotalCards() {
		
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
