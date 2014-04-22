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
class Player implements JsonSerializable {

	private $id;
	private $firstName;
	private $lastName;
	private $countryId;
	private $dateOfBirth;
	private $height;
	private $weight;
	private $position;
	private $imageUrl;
	private $db;
	
	public $number;

	/**
	Constructor
	@param id
	*/
	public function __construct($id, $firstName, $lastName, $countryId, $dateOfBirth, $height, $weight, $position, &$db) {
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
	
	
	public function getPosition() {
		return $this->position;
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
	
	
	public function getPlayedMatchesStats() {
		
		$playedMatches = array();
		$year = getLatestYear();
		for($i = 0; $i < sizeof($year)-1; $i++) {
			
			$playedMatches[$year[$i]['name']] = $this->db->getTotalNumberOfPlayerMatchesInterval($this->getId(), $year[$i]['timestamp'], $year[$i+1]['timestamp']);
			
		}
		
		return $playedMatches;
	}
	
	
	
	public function getWonMatchesStats() {
		
		$playedMatches = array();
		$year = getLatestYear();
		for($i = 0; $i < sizeof($year)-1; $i++) {
			
			$playedMatches[$year[$i]['name']] = $this->db->getTotalMatchesWonByPlayerInterval($this->getId(), $year[$i]['timestamp'], $year[$i+1]['timestamp']);
			
		}
		
		return $playedMatches;
	}
	
	
	
	public function getOveralStats() {
		
		$months = getAllMonths($this->db->getMatchDateBorder($this->getId(), true), $this->db->getMatchDateBorder($this->getId(), false));
		$matches = [];
		$matches_won = [];
		$cards = [];
		$goals = [];
		
		$count = 1;
		foreach ($months as $month => $timestamp) {
			if($count < sizeof($months)) {
				$matches[$month] = $this->db->getTotalNumberOfPlayerMatchesInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);
				$matches_won[$month] = $this->db->getTotalMatchesWonByPlayerInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);
				$cards[$month] = $this->db->getTotalCardsOfPlayerInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);
				$goals[$month] = $this->db->getGoalsOfPlayerInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);
				//var_dump(array_slice($months, $count-1, 1));
				//echo '<br>';
			}
			$count++;
		}
		
		
		return ['Matches' => $matches, 'Matches won' => $matches_won, 'Cards' => $cards, 'Goals' => $goals];
		
	}
	
	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
			'countryId' => $this->countryId,
			'dateOfBirth' => $this->dateOfBirth,
			'height' => $this->height,
			'weight' => $this->weight,
			'position' => $this->position,
			'goals' => $this->getTotalNumberOfGoals(),
			'matches' => $this->getTotalNumberOfMatches(),
			'matchesWon' => $this->getTotalNumberOfWonMatches()
		];
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
