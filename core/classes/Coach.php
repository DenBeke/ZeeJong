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
class Coach implements JsonSerializable {
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


	public function getOverallStats() {
		
		$months = getAllMonths($this->db->getMatchDateBorderCoach($this->getId(), true), $this->db->getMatchDateBorderCoach($this->getId(), false));
		$matches = [];
		$matches_won = [];
		
		$count = 1;
		foreach ($months as $month => $timestamp) {
			if($count < sizeof($months)) {
				$matches[$timestamp] = $this->db->getTotalNumberOfMatchesCoachedInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);
				$matches_won[$timestamp] = $this->db->getTotalMatchesWonAsCoachInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);
				//var_dump(array_slice($months, $count-1, 1));
				//echo '<br>';
			}
			$count++;
		}
		
		
		return ['Matches' => $matches, 'Matches won' => $matches_won];
		
	}


	public function getTotalMatches() {
		return $this->db->getTotalNumberOfMatchesCoached($this->id);
	}
	
	
	public function getTotalMatchesWon() {
		
	}
	
	
	public function getAllCoachedTeams() {
	
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
			'countryId' => $this->country
		];
	}

}
?>
