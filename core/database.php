<?php
/*
Database controll

Created: February 2014
*/

require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/classes/Bet.php');
require_once(dirname(__FILE__) . '/classes/Card.php');
require_once(dirname(__FILE__) . '/classes/Coach.php');
require_once(dirname(__FILE__) . '/classes/Coaches.php');
require_once(dirname(__FILE__) . '/classes/Competition.php');
require_once(dirname(__FILE__) . '/classes/Country.php');
require_once(dirname(__FILE__) . '/classes/Goal.php');
require_once(dirname(__FILE__) . '/classes/Match.php');
require_once(dirname(__FILE__) . '/classes/Player.php');
require_once(dirname(__FILE__) . '/classes/PlaysIn.php');
require_once(dirname(__FILE__) . '/classes/PlaysMatchInTeam.php');
require_once(dirname(__FILE__) . '/classes/Referee.php');
require_once(dirname(__FILE__) . '/classes/Score.php');
require_once(dirname(__FILE__) . '/classes/Team.php');
require_once(dirname(__FILE__) . '/classes/Tournament.php');
require_once(dirname(__FILE__) . '/classes/User.php');


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
	Test whether a specific username exists
	
	@param the username to test
	
	@return boolean
	*/
	public function doesUserNameExist($username) {
		//Query
		$query = "
			SELECT id FROM User
			WHERE username = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('s', $username)){
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
			throw new exception('Corrupt database: multiple users with same username' . " '$username'");
		}
		else if($numberOfResults < 1) {
			return false;
		}else{
			return true;
		}
	}

	/**
	Test whether a specific user exists
	
	@param the username to test
	
	@return boolean
	*/
	public function doesUserExist($id) {
		//Query
		$query = "
			SELECT username FROM User
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
			throw new exception('Corrupt database: multiple users with same username');
		}
		else if($numberOfResults < 1) {
			return false;
		}else{
			return true;
		}
	}

	/**
	Get the user with a given username
	
	@param username
	@return a User object or a user object with id -1 if no user with given username
	
	@exception when no user found with the given name
	*/
	public function getUser($username) {
		//Query
		$query = "
			SELECT id FROM User
			WHERE username = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('s', $username)){
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
			throw new exception('Corrupt database: multiple users with same username');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no user with the given id');
		}

		//Bind return values
		$statement->bind_result($id);
		
		//Fetch the rows of the return values
		$statement->fetch();

		//Close the statement		
		$statement->close();
			
		return new User($id);
	}
		
	/**
	Register a user with a given username
	
	@param username, password,emailaddress
	@return id of the newly added user
	*/
	public function registerUser($username, $salt,$hashedPassword, $emailAddress) {
		//Query
		$query = "INSERT INTO User (`username`,`salt`,`password`,`emailAddress`) VALUES (?,?,?,?)";

		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		//Bind parameters
		if(!$statement->bind_param('ssss', $username, $salt, $hashedPassword, $emailAddress)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		//Execute statement
		if (!$statement->execute()) {
		throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		//Close the statement		
		$statement->close();
		return $this->getUser($username)->getId();
	}
	
	/**
	Get the country with the given name
	
	@param name
	@return country
	
	@exception when no country found with the given name
	*/
	public function getCountry($name) {
		//Query
		$query = "
			SELECT * FROM Country
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
			throw new exception('Corrup database: multiple countries with the same name');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no country with the given name');
		}

		//Bind return values
		$statement->bind_result($id, $name);
		
		//Fetch the rows of the return values
		$statement->fetch();

		//Close the statement		
		$statement->close();
			
		return new Country($id, $name);
	}
	
	
	
	/**
	Add the country with the given name to the database
	
	@param name
	@return id of the newly added country or id of existing
	*/
	public function addCountry($name) {
		//Check if the competition isn't already in the database
		try {
			return $this->getCountry($name)->getId();
			 
		}
		catch (exception $e) {
			
		}
		
		
		//Query
		$query = "
			INSERT INTO Country (name)
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
		
		//Close the statement		
		$statement->close();
		
		return $this->getCountry($name)->getId();
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
			throw new exception('Corrup database: multiple competitions with the same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no competition with the given id');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $name);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Competition object TODO
				return new Competition($id, $name, $this);
				
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
				return new Competition($id, $name, $this);
				
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
				return new Tournament($id, $name, $competitionId, $this);
				
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
			throw new exception('Corrupt database: multiple tournaments with the id');
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
			throw new exception('Corrup database: multiple tournaments with the same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no tournament with the given id');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $name, $competitionId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Competition object TODO
				return new Tournament($id, $name, $competitionId, $this);
				
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
			throw new exception('Corrupt database: multiple referees with the same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no referee with the given id');
		}

		//Bind return values
		$statement->bind_result($id, $firstName, $lastName, $countryId);
		
		//Fetch the rows of the return values
		$statement->fetch();

		//Close the statement
		$statement->close();
			
		//Create new Player object TODO
		return new Referee($id, $firstName, $lastName, $countryId);
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
			throw new exception('Corrupt database: multiple coaches with the same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no coach with the given id');
		}

		//Bind return values
		$statement->bind_result($id, $firstName, $lastName, $countryId);
		
		//Fetch the rows of the return values
		$statement->fetch();

		//Close the statement
		$statement->close();
			
		//Create new Player object TODO
		return new Coach($id, $firstName, $lastName, $countryId);
	}

	/**
	Add a coaching relation to the database

	@param coachId
	@param teamId
	@param date

	@return coaches

	@exception when the team or coach does not exist
	*/	
	public function addCoaches($coachId, $teamId, $matchId) {

		try {

			if($this->checkTeamExists($teamId) && $this->checkCoachExists($coachId)) {

				//Check if the coaches relation isn't already in the database
				try {
					return $this->getCoaches($coachId, $teamId, $matchId)->getId();
					 
				}
				catch (exception $e) {

				}
				
				
				//Query
				$query = "
					INSERT INTO Coaches (coachId, teamId, matchId)
					VALUES (?, ?, ?);
				";
				
				//Prepare statement
				if(!$statement = $this->link->prepare($query)) {
					throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
				}
				
				//Bind parameters
				if(!$statement->bind_param('iii', $coachId, $teamId, $matchId)){
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
	public function getCoaches($coachId, $teamId, $matchId) {
		
		//Query
		$query = "
			SELECT * FROM Coaches
			WHERE coachId = ? AND
			teamId = ? AND
			matchId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iii', $coachId, $teamId, $matchId)){
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
			throw new exception('Corrupt database: multiple coaches relations with the same team, coach and match');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no coaches relation with the given team, coach and match');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $firstName, $lastName, $countryId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Coach object TODO
				return new Coaches($id);
				
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
				return new Team($id, $name, $countryId, $this);
				
				//Close the statement		
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}

	/**
	Get the team with the given id
	
	@param id

	@return team
	
	@exception when no team found with the given name and country
	*/
	public function getTeamById($id) {
		
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
			throw new exception('Error, there is no team with the given id');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $name, $countryId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Coach object TODO
				return new Team($id, $name, $countryId, $this);
				
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
	
	@param first name
	@param last name
	@param country id
	@param date of birth
	@param height
	@param weight

	@return id of the newly added player or id of existing
	*/
	public function addPlayer($firstName, $lastName, $countryId, $dateOfBirth, $height, $weight) {
	
		//Check if the player isn't already in the database
		try {
			return $this->getPlayer($firstName, $lastName, $countryId, $dateOfBirth, $height, $weight)->getId();
			 
		}
		catch (exception $e) {
		}
		
		//Query
		$query = "
			INSERT INTO Player (firstname, lastname, country, dateOfBirth, height, weight)
			VALUES (?, ?, ?, ?, ?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ssiiii', $firstName, $lastName, $countryId, $dateOfBirth, $height, $weight)){
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
	
	@param first name
	@param last name
	@param country id
	@param date of birth
	@param height
	@param weight

	@return player
	
	@exception when no player found with the given name, country and date of birth
	*/
	public function getPlayer($firstName, $lastName, $countryId, $dateOfBirth, $height, $weight) {
	

		//Query
		$query = "
			SELECT * FROM Player
			WHERE firstname = ? AND
			lastname = ? AND
			country = ? AND
			dateOfBirth = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('ssii', $firstName, $lastName, $countryId, $dateOfBirth)){
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
			throw new exception('Corrupt database: multiple players with the same name, country of origin and date of birth');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no player with the given name, country of origin and date of birth');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $firstName, $lastName, $countryId, $dateOfBirth, $height, $weight);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new Player($id, $firstName, $lastName, $countryId, $dateOfBirth, $height, $weight, $this);
				
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
		//Query
		$query = "
			SELECT * FROM Player
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
			throw new exception('Corrupt database: multiple players with the same name and country of origin');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no player with the given name and country of origin');
		}

		//Bind return values
		$statement->bind_result($id, $firstName, $lastName, $countryId, $dateOfBirth, $height, $weight);
		
		//Fetch the rows of the return values
		$statement->fetch();

		//Close the statement
		$statement->close();
			
		//Create new Player object TODO
		return new Player($id, $firstName, $lastName, $countryId, $dateOfBirth, $height, $weight, $this);
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
		if(!$statement->bind_param('iii', $playerId, $matchId, $time)){
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
		if(!$statement->bind_param('iii', $playerId, $time, $matchId)){
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
			throw new exception('Corrupt database: multiple goals with the same player, time and match');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no goal with the given player, time and match');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $playerId, $matchId, $time);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new Goal($id, $playerId, $matchId, $time);
				
				//Close the statement
				$statement->close();
				
			}
			
		}


		//Close the statement		
		$statement->close();
		
	}

	/**
	Get the goal with the id
	
	@param id

	@return goal
	
	@exception when no goal found with the given id
	*/
	public function getGoalById($id) {
	

		//Query
		$query = "
			SELECT * FROM `Goal`
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
			throw new exception('Corrupt database: multiple goals with the same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no goal with the given id');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $playerId, $matchId, $time);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new Goal($id, $playerId, $matchId, $time);
				
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

		if(!$this->checkTeamExists($teamA) || !$this->checkTeamExists($teamB) || !$this->checkTournamentExists($tournamentId)) {

			throw new exception('Error creating match, check integrity');
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
		if(!$statement->bind_param('iiiiii', $teamA, $teamB, $tournamentId, $refereeId, $date, $scoreId)){
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
			tournamentId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {

			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iiii', $teamA, $teamB, $refereeId, $tournamentId)){
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
				
				//Create new Match object TODO
				return new Match($id, $teamA, $teamB, $tournamentId, $refereeId, $date, $scoreId, $this);
				
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
			throw new exception('Corrup database: multiple matches with the same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no match with the given id');
		}
		else {
			
			//Bind return values
			$statement->bind_result($id, $teamA, $teamB, $tournamentId, $refereeId, $date, $scoreId);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Match object TODO
				return new Match($id, $teamA, $teamB, $tournamentId, $refereeId, $date, $scoreId, $this);
				
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

		if(!$this->checkMatchExists($matchId)) {
			throw new exception("Bad reference: player $playerId, team $teamId, match $matchId");
			return;
		}

		//Query
		$query = "
			INSERT INTO `PlaysMatchInTeam` (playerId, teamId, matchId, number)
			VALUES (?, ?, ?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iiii', $playerId, $teamId, $matchId, $number)){
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
			$statement->bind_result($id, $playerId, $teamId, $matchId, $number);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new PlaysMatchInTeam($id, $playerId, $teamId, $matchId, $number);
				
				
			}
			
			//Close the statement
			$statement->close();			
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
			throw new exception("Bad reference");
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
	Clear the PlaysIn table
	*/
	public function clearPlaysInTable() {

		if (!$this->link->query("TRUNCATE TABLE PlaysIn")) {
			throw new exception('Failed to clear the PlaysIn table');
		}
	}

	
	/**
	Add a new fault to the database
	This is a yellow card, red card or yellow card after red card.
	
	@param id of the player
	@param id of the match in which the fault occurs
	@param time in match
	@param type of the card
	*/
	public function addFoulCard($playerId, $matchId, $time, $color) {

		//Check if the match isn't already in the database
		try {
			return $this->getFoulCard($playerId, $matchId, $time, $color)->getId();
			 
		}
		catch (exception $e) {
		}

		if(!$this->checkMatchExists($matchId)) {

			throw new exception("Match Id '$matchId' doesn't exist!");

		}
		elseif(!$this->checkPlayerExists($playerId)) {

			throw new exception("Player Id '$playerId' doesn't exist!");

		}

		//Query
		$query = "
			INSERT INTO Cards (playerId, matchId, color, time)
			VALUES (?, ?, ?, ?);
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iiii', $playerId, $matchId, $color, $time)){
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

	public function getFoulCard($playerId, $matchId, $time, $color) {

		//Query
		$query = "
			SELECT * FROM `Cards`
			WHERE playerId = ? AND
			matchId = ? AND
			time = ? AND
			color = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('iiii', $playerId, $matchId, $time, $color)){
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
			throw new exception('Corrupt database: The same foul card occurs multiple times');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no match with the given player, match, time and color');
		}
		else {

			//Bind return values
			$statement->bind_result($id, $playerId, $matchId, $color, $time);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new Card($id, $playerId, $matchId, $color, $time);
				
				//Close the statement
				$statement->close();
				
			}
			
		}
	}	
	
	public function getFoulCardById($id) {

		//Query
		$query = "
			SELECT * FROM `Cards`
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
			throw new exception('Corrupt database: There are multiple foul cards with the same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no card with the given id');
		}
		else {

			//Bind return values
			$statement->bind_result($id, $playerId, $matchId, $color, $time);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new Card($id, $playerId, $matchId, $color, $time);
				
				//Close the statement
				$statement->close();
				
			}
			
		}
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

	public function getScoreById($id) {

		//Query
		$query = "
			SELECT * FROM `Score`
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
			throw new exception('Corrupt database: There are multiple score with the same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no score with the given id');
		}
		else {

			//Bind return values
			$statement->bind_result($id, $teamA, $teamB);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Player object TODO
				return new Score($id, $teamA, $teamB);
				
				//Close the statement
				$statement->close();
				
			}
			
		}
	}	

	public function getTotalNumberOfGoals($playerId) {

		//Query
		$query = "
			SELECT * FROM `Goal`
			WHERE playerId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $playerId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Store the result in the buffer
		$statement->store_result();
		

		return $statement->num_rows;		
	}

	public function getTotalNumberOfMatches($playerId) {


		//Query
		$query = "
			SELECT * FROM `PlaysMatchInTeam`
			WHERE playerId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $playerId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Store the result in the buffer
		$statement->store_result();
		

		return $statement->num_rows;		
	}

	public function getTotalNumberOfCards($playerId) {
	
		//Query
		$query = "
			SELECT * FROM `Cards`
			WHERE playerId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $playerId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Store the result in the buffer
		$statement->store_result();
		

		return $statement->num_rows;
	}

	public function getCoachForTeam($teamId) {
	
		//Query
		$query = "
			SELECT * FROM `Coaches`
			WHERE teamId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $teamId)){
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
			throw new exception('Corrupt database: There are multiple coaches coaching the same team');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no coach coaching this team');
		}
		else {

			//Bind return values
			$statement->bind_result($id);
			
			return $this->getCoachById($id);
			
		}
	}

	/**
	Returns all tournaments of the competition
	
	@return tournaments
	*/
	public function getTournamentsInCompetition($competitionId) {
	
		//Query
		$query = "
			SELECT * FROM `Tournament`
			WHERE competitionId = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $competitionId)){
			throw new exception('Binding parameters failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Execute statement
		if (!$statement->execute()) {
			throw new exception('Execute failed: (' . $statement->errno . ') ' . $statement->error);
		}
		
		//Store the result in the buffer
		$statement->store_result();
		

		$numberOfResults = $statement->num_rows;
		
		if($numberOfResults < 1) {
			throw new exception('Error, there are no Tournaments in this competition');
		}	
		else {

			//FINISH THIS
			//Bind return values
			$statement->bind_result($id, $name);
			
			//Fetch the rows of the return values
			while ($statement->fetch()) {
				
				//Create new Competition object TODO
				return new Competition($id, $name, $this);
				
				//Close the statement		
				$statement->close();
				
			}
		}
	}		

}

	date_default_timezone_set ( 'Europe/Brussels');
	$db = new Database();

	echo "<b>Adding all items... </b><br>";
	$db->addCountry("Germanolia");
	$db->addCompetition('DeathBattle');
	$db->addReferee('Filler', 'Data', 1);	
	$db->addReferee('Mathias', 'Truyts', 1);	
	$db->addTeam('fuck', 1);
	$db->addTeam('balls', 1);	
	$db->addTournament('DeathBattleTournamentVersion', 1);
	$db->addPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84);	
	$db->addMatch(1, 2, 3, 0, 1, 0, 1);	
	$db->addGoal(1, 0, 1);
	$db->addGoal(1, 1, 1);
	$db->addGoal(1, 2, 1);
	$db->addFoulCard(1, 1, 0, 2);
	$db->addFoulCard(1, 1, 1, 2);	
	$db->addPlayerToMatch(1, 1, 1, 11);
	$db->addPlayerToTeam(1, 1);
	$db->addCoach("Timo", "Beke", 1);
	echo "<b>Done! </b><br>";		

	echo "<br> <u><b>Card tests: </b></u><br>";
	echo "<b>Basic Getters: </b><br>";	
	echo "id: ", $db->getFoulCard(1, 1, 0, 2)->getId(), "<br>";	
	echo "playerId: ", $db->getFoulCard(1, 1, 0, 2)->getPlayer(), "<br>";
	echo "matchId: ", $db->getFoulCard(1, 1, 0, 2)->getMatch(), "<br>";		
	echo "time: ", $db->getFoulCard(1, 1, 0, 2)->getTime(), "<br>";	
	echo "type: ", $db->getFoulCard(1, 1, 0, 2)->getType(), "<br>";
	echo "<b>Basic Getters by id: </b><br>";	
	echo "id: ", $db->getFoulCardById(1)->getId(), "<br>";	
	echo "playerId: ", $db->getFoulCardById(1)->getPlayer(), "<br>";
	echo "matchId: ", $db->getFoulCardById(1)->getMatch(), "<br>";		
	echo "time: ", $db->getFoulCardById(1)->getTime(), "<br>";	
	echo "type: ", $db->getFoulCardById(1)->getType(), "<br>";



	echo "<br> <u><b>Coach tests: </b></u><br>";
	echo "<b>Basic Getters: </b><br>";
	echo $db->getCoach("Timo", "Beke", 1)->getId(), "<br>";
	echo $db->getCoach("Timo", "Beke", 1)->getFirstName(), "<br>";	
	echo $db->getCoach("Timo", "Beke", 1)->getLastName(), "<br>";	
	echo $db->getCoach("Timo", "Beke", 1)->getName(), "<br>";
	echo $db->getCoach("Timo", "Beke", 1)->getCountry(), "<br>";
	echo "<b>Basic Getters by id: </b><br>";
	echo $db->getCoachById(1)->getId(), "<br>";
	echo $db->getCoachById(1)->getFirstName(), "<br>";	
	echo $db->getCoachById(1)->getLastName(), "<br>";	
	echo $db->getCoachById(1)->getName(), "<br>";
	echo $db->getCoachById(1)->getCountry(), "<br>";



	echo "<br> <u><b>Country tests: </b></u><br>";
	echo "<b>Basic Getters: </b><br>";	
	echo $db->getCountry("Germanolia")->getId(), "<br>";
	echo $db->getCountry("Germanolia")->getName(), "<br>";	



	echo "<br> <u><b>Competition tests: </b></u> <br>";
	echo "<b>Basic Getters: </b><br>";	
	echo $db->getCompetition('DeathBattle')->getId(), "<br>";
	echo $db->getCompetitionById(1)->getName(), "<br>";



	echo "<br> <u><b>Goal tests: </b></u><br>";
	echo "<b>Basic Getters: </b><br>";
	echo $db->getGoal(1, 2, 1)->getId(), "<br>";
	echo $db->getGoal(1, 2, 1)->getPlayer(), "<br>";	
	echo $db->getGoal(1, 2, 1)->getMatch(), "<br>";	
	echo $db->getGoal(1, 2, 1)->getTime(), "<br>";
	echo "<b>Basic Getters by id: </b><br>";
	echo $db->getGoalById(1)->getId(), "<br>";
	echo $db->getGoalById(1)->getPlayer(), "<br>";	
	echo $db->getGoalById(1)->getMatch(), "<br>";	
	echo $db->getGoalById(1)->getTime(), "<br>";



	echo "<br> <u><b>Match tests: </b></u><br>";
	echo "<b>Basic Getters by ID: </b><br>";
	echo "teamA: ", $db->getMatchById(1)->getTeamA()->getName(), "<br>";
	echo "teamB: ", $db->getMatchById(1)->getTeamB()->getName(), "<br>";	
	echo "Score: ", $db->getMatchById(1)->getScore(), "<br>";	
	echo "Referee: ", $db->getMatchById(1)->getReferee()->getName(), "<br>";
	echo "Tournament: ", $db->getMatchById(1)->getTournament()->getName(), "<br>";
	echo "Date: ", $db->getMatchById(1)->getDate(), "<br>";		



	echo "<br> <u><b>Player tests: </b></u><br>";		
	echo "<b>Query tests: </b><br>";
	echo "Total Goals: ",$db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getTotalNumberOfGoals(), "<br>";
	echo "Total Matches: ",$db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getTotalNumberOfMatches(), "<br>";
	echo "Total Cards: ",$db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getTotalNumberOfCards(), "<br>";
	echo "<b>Basic Getters: </b><br>";
	echo "id: ", $db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getId(), "<br>";
	echo "First Name: ", $db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getFirstName(), "<br>";
	echo "Last Name: ", $db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getLastName(), "<br>";
	echo "Country: ", $db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getCountry(), "<br>";
	echo "Date of birth: ", $db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getDateOfBirth(), "<br>";
	echo "Height: ", $db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getHeight(), "<br>";
	echo "Weight: ", $db->getPlayer('Maarten', 'Stekelenburg', 1, 401493600, 194, 84)->getWeight(), "<br>";

	echo "<b>Query tests with id: </b><br>";
	echo "Total Goals: ", $db->getPlayerById(1)->getTotalNumberOfGoals(), "<br>";
	echo "Total Matches: ", $db->getPlayerById(1)->getTotalNumberOfMatches(), "<br>";
	echo "Total Cards: ", $db->getPlayerById(1)->getTotalNumberOfCards(), "<br>";
	echo "<b>Basic Getters by id: </b><br>";
	echo "id: ", $db->getPlayerById(1)->getId(), "<br>";
	echo "First Name: ", $db->getPlayerById(1)->getFirstName(), "<br>";
	echo "Last Name: ", $db->getPlayerById(1)->getLastName(), "<br>";
	echo "Country: ", $db->getPlayerById(1)->getCountry(), "<br>";
	echo "Date of birth: ", $db->getPlayerById(1)->getDateOfBirth(), "<br>";
	echo "Height: ", $db->getPlayerById(1)->getHeight(), "<br>";
	echo "Weight: ", $db->getPlayerById(1)->getWeight(), "<br>";



	echo "<br> <u><b>PlaysIn tests: </b></u><br>";
	echo "<b>Basic Getters: </b><br>";	
	echo "id: ",$db->getPlaysIn(1, 1)->getId(), "<br>";	
	echo "Player id: ",$db->getPlaysIn(1, 1)->getPlayer(), "<br>";	
	echo "Team id: ",$db->getPlaysIn(1, 1)->getTeam(), "<br>";



	echo "<br> <u><b>PlaysMatchInTeam tests: </b></u><br>";
	echo "<b>Basic Getters: </b><br>";	
	echo "id: ",$db->getPlaysMatchInTeam(1, 1, 1, 11)->getId(), "<br>";	
	echo "Player id: ",$db->getPlaysMatchInTeam(1, 1, 1, 11)->getPlayer(), "<br>";	
	echo "Team id: ",$db->getPlaysMatchInTeam(1, 1, 1, 11)->getTeam(), "<br>";
	echo "Match id: ",$db->getPlaysMatchInTeam(1, 1, 1, 11)->getMatch(), "<br>";	
	echo "Number: ",$db->getPlaysMatchInTeam(1, 1, 1, 11)->getNumber(), "<br>";		



	echo "<br> <u><b>Referee tests: </b></u><br>";
	echo "<b>Basic Getters: </b><br>";	
	echo "id: ",$db->getReferee("Mathias", "Truyts", 1)->getId(), "<br>";	
	echo "First name: ",$db->getReferee("Mathias", "Truyts", 1)->getFirstName(), "<br>";	
	echo "Last Name: ",$db->getReferee("Mathias", "Truyts", 1)->getLastName(), "<br>";
	echo "Full Name: ",$db->getReferee("Mathias", "Truyts", 1)->getName(), "<br>";	
	echo "Country: ",$db->getReferee("Mathias", "Truyts", 1)->getCountry(), "<br>";

	echo "<b>Basic Getters by ID: </b><br>";	
	echo "id: ",$db->getRefereeById(2)->getId(), "<br>";	
	echo "First name: ",$db->getRefereeById(2)->getFirstName(), "<br>";	
	echo "Last Name: ",$db->getRefereeById(2)->getLastName(), "<br>";
	echo "Full Name: ",$db->getRefereeById(2)->getName(), "<br>";	
	echo "Country: ",$db->getRefereeById(2)->getCountry(), "<br>";	



	echo "<br> <u><b>Score tests: </b></u><br>";
	echo "<b>Basic Getters by ID: </b><br>";	
	echo "id: ",$db->getMatchById(1)->getScore()->getId(), "<br>";	
	echo "Score: ",$db->getMatchById(1)->getScore(), "<br>";	
	echo "teamA Score: ",$db->getMatchById(1)->getScore()->getScoreA(), "<br>";
	echo "teamB Score: ",$db->getMatchById(1)->getScore()->getScoreB(), "<br>";	

?>
