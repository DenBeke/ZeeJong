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
	private $dateOfBirth;
	private $height;
	private $weight;

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
	Get the date of birth of the player
	@return The date of birth
	*/
	public function getDateOfBirth() {
		return $this->dateOfBirth;
	}

	/**
	Get the height of the player
	@return The height
	*/
	public function getHeight() {
		return $this->height;
	}

	/**
	Get the weight of the player
	@return The weight
	*/
	public function getWeight() {
		return $this->weight;
	}
	
	
	
	public function getTotalNumberOfGoals() {
	}
	
	public function getTotalNumberOfMatches() {
	}
	
	public function getTotalNumberOfCards() {
	}
	
	public function getTotalNumberOfWonMatches() {
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
