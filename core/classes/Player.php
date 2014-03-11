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
	private $countryId;
	private $dateOfBirth;
	private $height;
	private $weight;
	private $position;
	private $db;
	
	public $number;

	/**
	Constructor
	@param id
	*/
	public function __construct($id, $firstName, $lastName, $countryId, $dateOfBirth, $height, $weight, $position, $imageUrl, &$db) {
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->countryId = $countryId;
		$this->dateOfBirth = $dateOfBirth;
		$this->height = $height;
		$this->weight = $weight;
		$this->position = $position;
		$this->db = &$db;		
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
	public function getCountryId() {
		return $this->countryId;
	}


	/**
	Get the country of the player
	@return The country
	*/
	public function getCountry() {
		return $this->db->getCountryById($this->countryId);
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

		return $this->db->getTotalNumberOfGoals($this->id);		
	}
	
	public function getTotalNumberOfMatches() {
		
		return $this->db->getTotalNumberOfMatches($this->id);		
	}
	
	public function getTotalNumberOfCards() {
	
		return $this->db->getTotalNumberOfCards($this->id);
	}
	
	public function getTotalNumberOfWonMatches() {
		return $this->db->getTotalMatchesWonByPlayer($this->id);
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
