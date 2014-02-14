<?php
/*
Database controll

Created: February 2014
*/


require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/classes/Competition.php');


/**
@brief Class for managing database access.

This class takes care of everything related to modifying the database.
*/
class Database {
	

	private $link;

	
	/**
	@brief Constructor of the database object.
	
	The constructor will try to connect to the database
	If no details are given, connection info is taking from config.php
	
	@param hostname
	@param username
	@param password
	@param database name
	*/
	public function __construct($db_host = DB_HOST, $db_user = DB_USER, $db_password = DB_PASS, $db_database = DB_NAME) {
	
		//Connect to the database
		$this->link = new mysqli($db_host, $db_user, $db_password, $db_database);
		
		//Check the connection
		if (mysqli_connect_errno()) {
			$error = mysqli_connect_error();
			throw new Exception("Connect failed: $error");
		}
		
	}
	
	
	
	/**
	Destructor
	
	Closes connection
	*/
	public function __destruct() {
		
		$this->link->close();
		
	}
	
	
	
	/**
	Get the country with the given name
	
	@param name
	@return country
	
	@exception when no country found with the given name
	*/
	public function getCountry($name) {
		
	}
	
	
	
	/**
	Add the country with the given name to the database
	
	@param name
	@return id of the newly added country or id of existing
	*/
	public function addCountry($name) {
		
	}
	
	
	
	
	/**
	Get the competition with the given name
	
	@param name
	@return competition
	
	@exception when no competition found with the given name
	*/
	public function getCompetition($name) {
		
		//Query
		$query = "
			SELECT * FROM Competition
			WHERE name = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('s', $name)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Store the result in the buffer
		$statement->store_result();
		

		$numberOfResults = $statement->num_rows;
	
		//Check if the correct number of results are returned from the database
		if($numberOfResults > 1) {
			throw new exception('Corrup database: multiple competitions with the same name');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no competition with the given name');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $name);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Competition object TODO
				return new Competition($id, $name);
				
				//Close the statement		
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}
	
	
	
	/**
	Add the competition with the given name to the database
	
	@param name
	@return id of the newly added competition or id of existing
	*/
	public function addCompetition($name) {
		
		
		//Check if the competition isn't already in the database
		try {
			return $this->getCompetition($name)->getId();
			 
		}
		catch (exception $e) {
			
		}
		
		
		//Query
		$query = "
			INSERT INTO Competition (name)
			VALUES (?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('s', $name)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this works always...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;
		
	}
	
	
	
	/**
	Add the tournament with the given name to the database
	
	@param name
	@param competion id
	@return id of the newly added tournament or id of existing
	*/
	public function addTournament($name, $competitionId) {
		
		$competitionId = intval($competitionId);
	
	}
	
	
	
	/**
	Add a new referee to the database
	
	@param name
	@param id of the country
	@return id of the newly added referee or id of existing
	*/
	public function addReferee($name, $countryId) {
		
	}
	
	
	
	/**
	Add a new coach to the database
	
	@param name
	@param id of the country
	@return id of the newly added coach or id of existing
	*/
	public function addCoach($name, $countryId) {
		
	}
	
	
	
	/**
	Add a team to the database
	
	@param name
	@param id of the country
	@return id of the newly added team or id of existing
	*/
	public function addTeam($name, $countryId) {
		
	}
	
	
	
	/**
	Add a new player to the database
	
	NEED TO ADD ALL INFORMATION
	
	@return id of the newly added player or id of existing
	*/
	public function addPlayer($name) {
		
	}
	
	
	
	/**
	Add a goal to a match
	
	@param id of player
	@param time (minutes after beginning of match)
	@param id of match
	*/
	public function addGoal($playerId, $time, $matchId) {
		
	}
	
	
	/**
	Add a new match to the database
	
	@param team A
	@param team B
	@param number of goals of team A
	@param number of goals of team B
	@param id of referee
	@param date
	
	@return id of the newly added match or id of existing
	*/
	public function addMatch($teamA, $teamB, $scoreA, $scoreB, $refereeId, $date) {
		
	}
	
	
	
	/**
	Add a player to a given match
	
	The player will be associated with a team and the given match
	
	@param id of player
	@param id of match
	@param id of team
	*/
	public function addPlayerToMatch($playerId, $matchId, $teamId) {
		
	}
	

}


?>