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
class Referee implements JsonSerializable {
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
	
	public function getOverallStats() {
		
		$months = getAllMonths($this->db->getMatchDateBorderReferee($this->getId(), true), $this->db->getMatchDateBorderReferee($this->getId(), false));
		$matches = [];
		$cardsDealt = [];
		
		$count = 1;
		echo "Size: ",sizeof($months);
		foreach ($months as $month => $timestamp) {

			if($count < sizeof($months)) {
				$matches[$timestamp] = $this->db->getTotalNumberOfMatchesRefereedInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);
				$cardsDealt[$timestamp] = $this->db->getTotalCardsGivenInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);

			}
			$count++;
		}
		
		
		return ['Matches' => $matches, 'Cards given' => $cardsDealt];
		
	}	
	
	public function getTotalMatches() {

		return $this->db->getTotalNumberOfMatchesRefereed($this->id);
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

	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
			'countryId' => $this->countryId
		];
	}

}
?>
