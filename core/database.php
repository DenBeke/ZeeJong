<?php
/*
Database controll

Created: February 2014
*/


require_once(dirname(__FILE__) . '/config.php');


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
	Add the competition with the given name to the database
	
	@param name
	@return id of the newly added competition
	*/
	public function addCompetition($name) {
		
	}
	
	
	
	/**
	Add the tournament with the given name to the database
	
	@param name
	@param competion id
	@return id of the newly added tournament
	*/
	public function addTournament($name, $competitionId) {
		
		$competitionId = intval($competitionId);
	
	}
	
	
	
	/**
	Add a new referee to the database
	
	@param name
	@param id of the country
	@return id of the newly added referee
	*/
	public function addReferee($name, $countryId) {
		
	}
	
	
	
	/**
	Add a new coach to the database
	
	@param name
	@param id of the country
	@return id of the newly added coach
	*/
	public function addCoach($name, $countryId) {
		
	}
	
	
	
	/**
	Add a team to the database
	
	@param name
	@param id of the country
	@return id of the newly added team
	*/
	public function addTeam($name, $countryId) {
		
	}
	
	
	
	/**
	Add a new player to the database
	
	NEED TO ADD ALL INFORMATION
	
	@return id of the newly added player
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
	
	@return id of the newly added match
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