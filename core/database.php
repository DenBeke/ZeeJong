<?php
/*
Database controll

Created: February 2014
*/

require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/classes/Bet.php');
require_once(dirname(__FILE__) . '/classes/Coach.php');
require_once(dirname(__FILE__) . '/classes/Coaches.php');
require_once(dirname(__FILE__) . '/classes/Competition.php');
require_once(dirname(__FILE__) . '/classes/Fault.php');
require_once(dirname(__FILE__) . '/classes/Goal.php');
require_once(dirname(__FILE__) . '/classes/match.php');
require_once(dirname(__FILE__) . '/classes/Player.php');
require_once(dirname(__FILE__) . '/classes/PlaysIn.php');
require_once(dirname(__FILE__) . '/classes/PlaysMatchInTeam.php');
require_once(dirname(__FILE__) . '/classes/Referee.php');
require_once(dirname(__FILE__) . '/classes/Score.php');
require_once(dirname(__FILE__) . '/classes/Team.php');
require_once(dirname(__FILE__) . '/classes/Tournament.php');


error_reporting(E_ALL);
ini_set('display_errors', 1);

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
	Get the competition with the given id
	
	@param id
	@return competition
	
	@exception when no competition found with the given id
	*/
	public function getCompetitionById($id) {
		
		//Query
		$query = "
			SELECT * FROM Competition
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('s', $id)){
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
	Check if a competition exists with a given ID
	
	@param id
	@return true if the competition exists
	@return false if the competition doesn't exist

	@exception When there are multiple competitions with the same ID
	*/
	public function checkCompetitionExists($id) {
		
		//Query
		$query = "
			SELECT * FROM Competition
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('s', $id)){
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
			$statement->close();
			return false;
		}
		else {
			$statement->close();
			return true;
			
		}
	
	
		//Close the statement		
		$statement->close();
		
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

		//Check if the competition isn't already in the database
		try {
			return $this->getTournament($name, $competitionId)->getId();
			 
		}
		catch (exception $e) {
			
		}
		
		if(!$this->checkCompetitionExists($competitionId)) {

			return;
		}
		

		//Query
		$query = "
			INSERT INTO Tournament (name, competitionId)
			VALUES (?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('si', $name, $competitionId)){
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
	Get the tournament with the given name and competition ID
	
	@param name 
	@param competitionId
	@return tournament
	
	@exception when no tournament found with the given name and competition ID
	*/
	public function getTournament($name, $competitionId) {
		
		//Query
		$query = "
			SELECT * FROM Tournament
			WHERE name = ? AND
			competitionId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('si', $name, $competitionId)){
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
			throw new exception('Corrup database: multiple tournaments with the same name');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no tournament with the given name');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $name, $competitionId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Competition object TODO
				return new Tournament($id, $name);
				
				//Close the statement		
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}	
	
	/**
	Check if the tournament exists
	
	@param id

	@return true if tournament exists
	@return false if tournament doesn't exist
	
	@exception When there is more than 1 tournament with that id
	*/
	public function checkTournamentExists($id) {
		
		//Query
		$query = "
			SELECT * FROM `Tournament`
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $id)){
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
			throw new exception('Corrupt database: multiple referee with the same name and country of origin');
		}
		else if($numberOfResults < 1) {
			
			//Close the statement		
			$statement->close();
			return false;
		}
		else {

			//Close the statement		
			$statement->close();			
			return true;
			
		}


		//Close the statement		
		$statement->close();
		
	}	
	
	
	/**
	Get the competition with the given id
	
	@param id
	@return competition
	
	@exception when no competition found with the given id
	*/
	public function getTournamentById($id) {
		
		//Query
		$query = "
			SELECT * FROM Tournament
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('s', $id)){
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
				return new Tournament($id);
				
				//Close the statement		
				$statement->close();
				
			}
			
		}
	
	
		//Close the statement		
		$statement->close();
		
	}
	
	
	/**
	Add a new referee to the database
	
	@param first name
	@param last name
	@param id of the country
	@return id of the newly added referee or id of existing
	*/
	public function addReferee($firstName, $lastName, $countryId) {

		//Check if the referee isn't already in the database
		try {
			return $this->getReferee($firstName, $lastName, $countryId)->getId();
			 
		}
		catch (exception $e) {
		}
		
		
		//Query
		$query = "
			INSERT INTO Referee (firstName, lastName, countryId)
			VALUES (?, ?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ssi', $firstName, $lastName, $countryId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this always works...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;		
		
	}
	
	/**
	Get the referee with the given name and country
	
	@param firstName
	@param lastName
	@param countryId

	@return referee
	
	@exception when no referee found with the given name and country
	*/
	public function getReferee($firstName, $lastName, $countryId) {
		
		//Query
		$query = "
			SELECT * FROM Referee
			WHERE firstname = ? AND
			lastName = ? AND
			countryId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ssi', $firstName, $lastName, $countryId)){
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
			throw new exception('Corrupt database: multiple referee with the same name and country of origin');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no referee with the given name and country of origin');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $firstName, $lastName, $countryId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Coach object TODO
				return new Referee($id, $firstName, $lastName, $countryId);
				
				//Close the statement		
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}
	
	/**
	Check if the referee exists
	
	@param id

	@return true if referee exists
	@return false if referee doesn't exist
	
	@exception When there is more than 1 referee with that id
	*/
	public function checkRefereeExists($id) {
		
		//Query
		$query = "
			SELECT * FROM Referee
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $id)){
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
			throw new exception('Corrupt database: multiple referee with the same name and country of origin');
		}
		else if($numberOfResults < 1) {
			
			//Close the statement		
			$statement->close();
			return false;
		}
		else {

			//Close the statement		
			$statement->close();			
			return true;
			
		}


		//Close the statement		
		$statement->close();
		
	}	


	/**
	Get the referee with the given id
	
	@param id
	@return referee
	
	@exception when no referee found with the given id
	*/
	public function getRefereeById($id) {
		// TODO: Get the object from somewhere
	}
	
	

	/**
	Add a new coach to the database
	
	@param first name
	@param last name
	@param id of the country
	@return id of the newly added coach or id of existing
	*/
	public function addCoach($firstName, $lastName, $countryId) {
	
		//Check if the coach isn't already in the database
		try {
			return $this->getCoach($firstName, $lastName, $countryId)->getId();
			 
		}
		catch (exception $e) {
			echo '?';
		}
		
		
		//Query
		$query = "
			INSERT INTO Coach (firstName, lastName, country)
			VALUES (?, ?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ssi', $firstName, $lastName, $countryId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this always works...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;		
	}


	/**
	Get the coach with the given name and country
	
	@param firstName
	@param lastName
	@param countryId

	@return coach
	
	@exception when no coach found with the given name and country
	*/
	public function getCoach($firstName, $lastName, $countryId) {
		
		//Query
		$query = "
			SELECT * FROM Coach
			WHERE firstname = ? AND
			lastName = ? AND
			country = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ssi', $firstName, $lastName, $countryId)){
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
			throw new exception('Corrupt database: multiple coaches with the same name and country of origin');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no coach with the given name and country of origin');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $firstName, $lastName, $countryId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Coach object TODO
				return new Coach($id, $firstName, $lastName, $countryId);
				
				//Close the statement		
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}	

	/**
	check if a coach with the given id exists

	@param id

	@return true if coach exists
	*/
	public function checkCoachExists($id) {

		//Query
		$query = "
			SELECT * FROM Coach
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $id)){
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
			throw new exception('Corrupt database: multiple coaches with the same id.');
		}
		else if($numberOfResults < 1) {

			//Close the statement		
			$statement->close();		
			return false;
		}
		else {

			//Close the statement		
			$statement->close();		
			return true;
		}
		//Close the statement		
		$statement->close();
	}
	
	
	/**
	Get the coach with the given id
	
	@param id
	@return coach
	
	@exception when no coach found with the given id
	*/
	public function getCoachById($id) {
		// TODO: Get the object from somewhere
	}

	/**
	Add a coaching relation to the database

	@param coachId
	@param teamId
	@param date

	@return coaches

	@exception when the team or coach does not exist
	*/	
	public function addCoaches($coachId, $teamId, $date) {

		try {

			if($this->checkTeamExists($teamId) && $this->checkCoachExists($coachId)) {

				//Check if the coaches relation isn't already in the database
				try {
					return $this->getCoaches($coachId, $teamId, $date)->getId();
					 
				}
				catch (exception $e) {

				}
				
				
				//Query
				$query = "
					INSERT INTO Coaches (coachId, teamId, date)
					VALUES (?, ?, ?);
				";
				
				//Prepare statement
				if(!$statement = $this->link->prepare($query)) {
					throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
				}
				
				//Bind parameters
				if(!$statement->bind_param('sss', $coachId, $teamId, $date)){
					throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
				}
				
				//Execute statement
				if (!$statement->execute()) {
					throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
				}
				
				
				//Keep id of the last inserted row
				$id = $statement->insert_id; //TODO Check if this always works...
				
				//Close the statement		
				$statement->close();
				
				
				return $id;				
			}

			else {

				return;
			}
		}

		catch(exception $e) {

			return;
		}
	}

	/**
	Get the coach with the given name and country
	
	@param firstName
	@param lastName
	@param countryId

	@return coach
	
	@exception when no coach found with the given name and country
	*/
	public function getCoaches($coachId, $teamId, $date) {
		
		//Query
		$query = "
			SELECT * FROM Coaches
			WHERE coachId = ? AND
			teamId = ? AND
			date = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('sss', $coachId, $teamId, $date)){
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
			throw new exception('Corrupt database: multiple coaches relations with the same team, coach and date');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no coaches relation with the given team, coach and date');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $firstName, $lastName, $countryId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Coach object TODO
				return new Coaches($id, $coachId, $teamId, $date);
				
				//Close the statement		
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}	
	
	/**
	Add a team to the database
	
	@param name
	@param id of the country
	@return id of the newly added team or id of existing
	*/
	public function addTeam($name, $countryId) {
		
		//Check if the coach isn't already in the database
		try {
			return $this->getTeam($name, $countryId)->getId();
			 
		}
		catch (exception $e) {

			echo '?';
		}
		
		//Query
		$query = "
			INSERT INTO Team (name, country)
			VALUES (?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('si', $name, $countryId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this always works...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;			
	}

	/**
	Get the team with the given name and country
	
	@param name
	@param countryId

	@return team
	
	@exception when no team found with the given name and country
	*/
	public function getTeam($name, $countryId) {
		
		//Query
		$query = "
			SELECT * FROM Team
			WHERE name = ? AND
			country = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('si', $name, $countryId)){
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
			throw new exception('Corrupt database: multiple teams with the same name and country of origin');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no team with the given name and country of origin');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $name, $countryId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Coach object TODO
				return new Team($id, $name, $countryId);
				
				//Close the statement		
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}

	/**
	Check if a team with the given id exists

	@param id

	@return true if team exists
	*/
	public function checkTeamExists($id) {

		//Query
		$query = "
			SELECT * FROM Team
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $id)){
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
			throw new exception('Corrupt database: multiple teams with the same id');
		}
		else if($numberOfResults < 1) {

			//Close the statement		
			$statement->close();		
			return false;
		}
		else {

			//Close the statement		
			$statement->close();		
			return true;
		}
		//Close the statement		
		$statement->close();
	}
	
	
	/**
	Add a new player to the database
	
	NEED TO ADD ALL INFORMATION
	
	@param first name
	@param last name
	@param countryId
	@return id of the newly added player or id of existing
	*/
	public function addPlayer($firstName, $lastName, $countryId) {
	
		//Check if the player isn't already in the database
		try {
			return $this->getPlayer($firstName, $lastName, $countryId)->getId();
			 
		}
		catch (exception $e) {
		}
		
		//Query
		$query = "
			INSERT INTO Player (firstname, lastname, country)
			VALUES (?, ?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ssi', $firstName, $lastName, $countryId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this always works...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;	

	}
	
	/**
	Get the player with the given name and country
	
	@param firstName
	@param lastName
	@param countryId

	@return player
	
	@exception when no player found with the given name and country
	*/
	public function getPlayer($firstName, $lastName, $countryId) {
	

		//Query
		$query = "
			SELECT * FROM Player
			WHERE firstname = ? AND
			lastname = ? AND
			country = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ssi', $firstName, $lastName, $countryId)){
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
			throw new exception('Corrupt database: multiple players with the same name and country of origin');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no player with the given name and country of origin');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $firstName, $lastName, $countryId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new Player($id, $firstName, $lastName, $countryId);
				
				//Close the statement
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}	
	
	/**
	Check if a player exists with a given ID
	
	@param id
	@return true if the player exists
	@return false if the player doesn't exist

	@exception When there are multiple players with the same ID
	*/
	public function checkPlayerExists($id) {
		
		//Query
		$query = "
			SELECT * FROM `Player`
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $id)){
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
			throw new exception('Corrup database: multiple players with the same id');
		}
		else if($numberOfResults < 1) {
			$statement->close();
			return false;
		}
		else {
			$statement->close();
			return true;
			
		}
	
	
		//Close the statement		
		$statement->close();
		
	}	

	
	/**
	Get the player with the given id
	
	@param id
	@return player
	
	@exception when no player found with the given id
	*/
	public function getPlayerById($id) {
		// TODO: Get the object from somewhere
	}
	
	

	/**
	Add a goal to a match
	
	@param id of player
	@param time (minutes after beginning of match)
	@param id of match
	*/
	public function addGoal($playerId, $time, $matchId) {

		//Check if the player isn't already in the database
		try {
			return $this->getGoal($playerId, $time, $matchId)->getId();
			 
		}
		catch (exception $e) {
		}
		
		if(!$this->checkPlayerExists($playerId) || !$this->checkMatchExists($matchId)) {

			return;
		}

		//Query
		$query = "
			INSERT INTO `Goal` (playerId, matchId, time)
			VALUES (?, ?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iis', $playerId, $matchId, $time)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this always works...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;			
	}
	
	/**
	Get the goal with the given player, match and time
	
	@param playerId
	@param matchId
	@param time

	@return goal
	
	@exception when no goal found with the given player, match and time
	*/
	public function getGoal($playerId, $time, $matchId) {
	

		//Query
		$query = "
			SELECT * FROM `Goal`
			WHERE playerId = ? AND
			time = ? AND
			matchId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('isi', $playerId, $time, $matchId)){
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
			throw new exception('Corrupt database: multiple players with the same name and country of origin');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no player with the given name and country of origin');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $playerId, $matchId, $time);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new Goal($id, $playerId, $time, $matchId);
				
				//Close the statement
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}	

	
	/**
	Add a new match to the database
	
	@param team A
	@param team B
	@param number of goals of team A
	@param number of goals of team B
	@param id of referee
	@param date
	@param id of the tournament
	
	@return id of the newly added match or id of existing
	*/
	public function addMatch($teamA, $teamB, $scoreA, $scoreB, $refereeId, $date, $tournamentId) {
		
		//Check if the match isn't already in the database
		try {
			return $this->getMatch($teamA, $teamB, $refereeId, $date, $tournamentId)->getId();
			 
		}
		catch (exception $e) {
		}

		if(!$this->checkTeamExists($teamA) || !$this->checkTeamExists($teamB) || !$this->checkRefereeExists($refereeId) || !$this->checkTournamentExists($tournamentId)) {

			return;
		}

		//Create a score for this match and save the id of this score
		$scoreId = $this->addScore($scoreA, $scoreB);

		//Query
		$query = "
			INSERT INTO `Match` (teamA, teamB, tournamentId, refereeId, date, scoreId)
			VALUES (?, ?, ?, ?, ?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iiiisi', $teamA, $teamB, $tournamentId, $refereeId, $date, $scoreId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this always works...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;			
	}
	
	public function getMatch($teamA, $teamB, $refereeId, $date, $tournamentId) {

		//Query
		$query = "
			SELECT * FROM `Match`
			WHERE teamA = ? AND
			teamB = ? AND
			refereeId = ? AND
			date = ? AND
			tournamentId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {

			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iiisi', $teamA, $teamB, $refereeId, $date, $tournamentId)){
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
			throw new exception('Corrupt database: multiple matches with the same teams, referee, date and tournament');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no match with the given teams, referee, date and tournament');
		}
		else {

			//Bind return values
			$statement->bind_result($id, $teamA, $teamB, $tournamentId, $refereeId, $date, $scoreId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new Match($teamA, $teamB, $tournamentId, $refereeId, $date, $scoreId);
				
				//Close the statement
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
	}
	
	
	/**
	Get the match with the given id
	
	@param id
	@return match
	
	@exception when no competition found with the given id
	*/
	public function getMatchById($id) {
		
		//Query
		$query = "
			SELECT * FROM `Match`
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('s', $id)){
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
			$statement->bind_result($id, $teamAId, $teamBId, $tournamentId, $refereeId, $date, $scoreId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Competition object TODO
				return new Match($id);
				
				//Close the statement		
				$statement->close();
				
			}
			
		}
	
	
		//Close the statement		
		$statement->close();
		
	}
	
	/**
	Check if a match exists with a given ID
	
	@param id
	@return true if the match exists
	@return false if the match doesn't exist

	@exception When there are multiple match with the same ID
	*/
	public function checkMatchExists($id) {
		
		//Query
		$query = "
			SELECT * FROM `Match`
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $id)){
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
			throw new exception('Corrup database: multiple matches with the same id');
		}
		else if($numberOfResults < 1) {
			$statement->close();
			return false;
		}
		else {
			$statement->close();
			return true;
			
		}
	
	
		//Close the statement		
		$statement->close();
		
	}		
	
	
	
	/**
	Add a player to a given match
	
	The player will be associated with a team and the given match
	
	@param id of player
	@param id of match
	@param id of team
	@param position number of the player
	*/
	public function addPlayerToMatch($playerId, $matchId, $teamId, $number) {
		
		//Check if this isn't already in the database
		try {

			return $this->getPlaysMatchInTeam($playerId, $matchId, $teamId, $number);
		}

		catch (exception $e) {
		}

		if(!$this->checkPlaysIn($playerId, $teamId) || !$this->checkMatchExists($matchId)) {

			return;
		}

		//Query
		$query = "
			INSERT INTO `PlaysMatchInTeam` (playerId, teamId, matchId)
			VALUES (?, ?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iii', $playerId, $teamId, $matchId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this always works...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;				
	}

	public function getPlaysMatchInTeam($playerId, $teamId, $matchId, $number) {

		//Query
		$query = "
			SELECT * FROM `PlaysMatchInTeam`
			WHERE playerId = ? AND
			teamId = ? AND
			matchId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iii', $playerId, $teamId, $matchId)){
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
			throw new exception('Corrupt database: The same player plays in the same team multiple times');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no match with the given player, team, number and match');
		}
		else {

			//Bind return values
			$statement->bind_result($id, $playerId, $teamId, $matchId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new PlaysMatchInTeam($id, $playerId, $teamId, $matchId, $number);
				
				//Close the statement
				$statement->close();
				
			}
			
		}
	}	
	
	/**
	Add a player to a given team
	
	The player will be associated with a team
	
	@param id of player
	@param id of team
	*/	
	public function addPlayerToTeam($playerId, $teamId) {

		//Check if the match isn't already in the database
		try {
			return $this->getPlaysIn($playerId, $teamId)->getId();
			 
		}
		catch (exception $e) {
		}

		if(!$this->checkTeamExists($teamId) || !$this->checkPlayerExists($playerId)) {

			return;
		}

		//Query
		$query = "
			INSERT INTO `PlaysIn` (playerId, teamId)
			VALUES (?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ii', $playerId, $teamId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this always works...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;				
	}

	public function getPlaysIn($playerId, $teamId) {

		//Query
		$query = "
			SELECT * FROM `PlaysIn`
			WHERE playerId = ? AND
			teamId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {

			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ii', $playerId, $teamId)){
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
			throw new exception('Corrupt database: The same player plays in the same team multiple times');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no match with the given player and team');
		}
		else {

			//Bind return values
			$statement->bind_result($id, $playerId, $teamId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new PlaysIn($id, $playerId, $teamId);
				
				//Close the statement
				$statement->close();
				
			}
			
		}
	}

	public function checkPlaysIn($playerId, $teamId) {

		//Query
		$query = "
			SELECT * FROM `PlaysIn`
			WHERE playerId = ? AND
			teamId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {

			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ii', $playerId, $teamId)){
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
			throw new exception('Corrupt database: The same player plays in the same team multiple times');
		}
		else if($numberOfResults < 1) {
			$statement->close();
			return false;
		}
		else {

			//Close the statement
			$statement->close();
			return true;
			
		}


		//Close the statement		
		$statement->close();
	}	
	
	/**
	Add a new fault to the database
	This is a yellow card, red card or yellow card after red card.
	
	@param id of the player
	@param id of the match in which the fault occurs
	@param time in match
	@param type of the card
	*/
	public function addFaultCard($playerId, $matchId, $time, $type) {
		
	}
	
	
	/**
	Add a new score to the database
	
	@param team A
	@param team B

	@return id of the newly added score or id of existing
	*/
	public function addScore($teamA, $teamB) {
		
		//Query
		$query = "
			INSERT INTO Score (teamA, teamB)
			VALUES (?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ii', $teamA, $teamB)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		
		//Keep id of the last inserted row
		$id = $statement->insert_id; //TODO Check if this always works...
		
		//Close the statement		
		$statement->close();
		
		
		return $id;	

	}		

}

	
?>