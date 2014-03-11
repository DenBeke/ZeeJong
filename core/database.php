<?php
/*
 Database controll

 Created: February 2014
*/

require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/Selector.php');
require_once(dirname(__FILE__) . '/functions.php');
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
	private $statements = array();
	private $statements2 = array();

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
		$this->con = new PDO("mysql:host=$db_host;dbname=$db_database", $db_user, $db_password);

		//Connect to the database
		$this -> link = new mysqli($db_host, $db_user, $db_password, $db_database);

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

		foreach($this->statements as $statement) {
			$statement->close();
		}

		$this->link->close();

	}

	public function select($selector) {
		//echo "<pre>";
		//print_r($selector->sql());
		//echo "</pre>";
		$statement = $this->getStatement2($selector->sql());
		$statement->setFetchMode(PDO::FETCH_ASSOC);

		$statement->execute($selector->values());

		$results = [];
		while($result = $statement->fetch()) {
			array_push($results, $result);
		}

		return $results;
	}

	private function getStatement2($query) {
		$query = trim($query);

		if(!isset($this->statements2[$query])) {
			if(!($this->statements2[$query] = $this->con->prepare($query))) {
				unset($this->statements2[$query]);
				throw new exception('Prepare failed: (' . $this->con->errno . ') ' . $this->con->error);
			}
		}

		return $this->statements2[$query];
	}

	private function getStatement($query) {
		$query = trim($query);

		if(!isset($this->statements[$query])) {
			if(!($this->statements[$query] = $this->link->prepare($query))) {
				unset($this->statements[$query]);
				throw new exception('Prepare failed: (' . $this -> link -> errno . ') ' . $this -> link -> error);
			}
		}

		return $this->statements[$query];
	}

	/**
	 Get the matchId from a bet

	 @return the matchId
	 */
	public function getMatchFromBet($id) {
		$sel = new \Selector('Bet');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['matchId'];
	}


	/**
	 Get the bets made by a user
	 @param the id of the user
	 @return the id's of the bets this user made
	 */
	 public function getUserBets($id){
	 	$sel = new \Selector('Bet');
		$sel->filter([['userId', '=', $id]]);

		$result = $this->select($sel);

		$result2=array();
		foreach ($result as $val) {
			array_push($result2,$val['id']);
		}

		return $result2;
	 }


	/**
	 Get the teamId from a bet

	 @return the teamId
	 */
	public function getTeamFromBet($id) {
		$sel = new \Selector('Bet');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['teamId'];
	}

	/**
	 Get the userId from a bet

	 @return the userId
	 */
	public function getUserFromBet($id) {
		$sel = new \Selector('Bet');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['userId'];
	}


	/**
	 Get the amount of money from a bet

	 @return the userId
	 */
	public function getMoneyFromBet($id) {
		$sel = new \Selector('Bet');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['amount'];
	}


	/**
	 Get the username of the user

	 @return the username of the user
	 */
	public function getUserName($id) {
		$sel = new \Selector('User');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['username'];
	}

	/**
	 Get the hashed password of the user

	 @return the hashed password of the user
	 */
	public function getUserPasswordHash($id) {
		$sel = new \Selector('User');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['password'];
	}

	/**
	 Get the salt of the user

	 @return the salt password of the user
	 */
	public function getUserPasswordSalt($id) {
		$sel = new \Selector('User');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['salt'];
	}

	/**
	 Get the email address the user

	 @return the salt password of the user
	 */
	public function getUserMail($id) {
		$sel = new \Selector('User');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['emailAddress'];
	}

	/**
	 Set the emailaddress of a user with a certain ID

	 @param id,emailaddress
	 */
	public function setUserMail($id, $emailAddress) {

		//Query
		$query = "
			UPDATE User
			SET emailAddress = ?
			WHERE id = ?;
		";

		// Test if user exists
		if(!$this->doesUserExist($id)){
			throw new exception('User with given ID does not exists');
		}


		//Prepare statement
		$statement = $this->getStatement($query);
		//Bind parameters
		if (!$statement -> bind_param('si', $emailAddress,$id)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}
		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}


	}

	/**
	 Set the salt of a user with a certain ID

	 @param id,salt
	 */
	public function setUserSalt($id, $salt) {

		//Query
		$query = "
			UPDATE User
			SET salt = ?
			WHERE id = ?;
		";

		// Test if user exists
		if(!$this->doesUserExist($id)){
			throw new exception('User with given ID does not exists');
		}


		//Prepare statement
		$statement = $this->getStatement($query);
		//Bind parameters
		if (!$statement -> bind_param('si',$salt, $id)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}
		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

	}

	/**
	 Set the hashed password of a user with a certain ID

	 @param id,hash
	 */
	public function setUserHash($id, $hash) {

		//Query
		$query = "
			UPDATE User
			SET password = ?
			WHERE id = ?;
		";

		// Test if user exists
		if(!$this->doesUserExist($id)){
			throw new exception('User with given ID does not exists');
		}


		//Prepare statement
		$statement = $this->getStatement($query);
		//Bind parameters
		if (!$statement -> bind_param('si',$hash, $id)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}
		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}


	}


	/**
	 Test whether a specific username exists

	 @param the username to test

	 @return boolean
	 */
	public function doesUserNameExist($username) {
		$sel = new \Selector('User');
		$sel->filter([['username', '=', $username]]);

		$result = $this->select($sel);

		return count($result) == 1;
	}

	/**
	 Test whether a specific user exists

	 @param the username to test

	 @return boolean
	 */
	public function doesUserExist($id) {
		$sel = new \Selector('User');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);

		return count($result) == 1;
	}

	/**
	 Get the user with a given username

	 @param username
	 @return a User object

	 @exception when no user found with the given name
	 */
	public function getUser($username) {
		$sel = new \Selector('User');
		$sel->filter([['username', '=', $username]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $this->resultToUsers($result)[0];
	}

	/**
	 Register a user with a given username

	 @param username, password,emailaddress
	 @return id of the newly added user
	 */
	public function registerUser($username, $salt, $hashedPassword, $emailAddress) {
		//Query
		$query = "INSERT INTO User (`username`,`salt`,`password`,`emailAddress`) VALUES (?,?,?,?)";

		//Prepare statement
		$statement = $this->getStatement($query);
		//Bind parameters
		if (!$statement -> bind_param('ssss', $username, $salt, $hashedPassword, $emailAddress)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}
		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		return $this -> getUser($username) -> getId();
	}

	/**
	 Get the country with the given name

	 @param name
	 @return country

	 @exception when no country found with the given name
	 */
	public function getCountry($name) {
		$sel = new \Selector('Country');
		$sel->filter([['name', '=', $name]]);

		$result = $this->select($sel);
		$countries = $this->resultToCountries($result);

		if(count($countries) != 1) {
			throw new exception('Could not find country with name ' . $name);
		}

		return $countries[0];
	}

	/**
	Get the country with the given id

	@param id
	@return country

	@exception when no country found with the given name
	*/
	public function getCountryById($countryId) {
		$sel = new \Selector('Country');
		$sel->filter([['id', '=', $countryId]]);

		$result = $this->select($sel);
		$countries = $this->resultToCountries($result);

		if(count($countries) != 1) {
			throw new exception('Could not find country with id ' . $id);
		}

		return $countries[0];
	}

	/**
	 Add the country with the given name to the database

	 @param name
	 @return id of the newly added country or id of existing
	 */
	public function addCountry($name) {
		//Check if the competition isn't already in the database
		try {
			return $this -> getCountry($name) -> getId();

		} catch (exception $e) {

		}

		//Query
		$query = "
			INSERT INTO Country (name)
			VALUES (?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('s', $name)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		return $this -> getCountry($name) -> getId();
	}

	/**
	 Get the competition with the given id

	 @param id
	 @return competition

	 @exception when no competition found with the given id
	 */
	public function getCompetitionById($id) {
		$sel = new \Selector('Competition');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$competitions = $this->resultToCompetitions($result);

		if(count($competitions) != 1) {
			throw new exception('Could not find competition with id ' . $id);
		}

		return $competitions[0];
	}

	/**
	 Check if a competition exists with a given ID

	 @param id
	 @return true if the competition exists
	 @return false if the competition doesn't exist

	 @exception When there are multiple competitions with the same ID
	 */
	public function checkCompetitionExists($id) {
		$sel = new \Selector('Competition');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);

		return count($result) == 1;
	}

	/**
	 Get the competition with the given name

	 @param name
	 @return competition

	 @exception when no competition found with the given name
	 */
	public function getCompetition($name) {
		$sel = new \Selector('Competition');
		$sel->filter([['name', '=', $name]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $this->resultToCompetitions($result)[0];
	}

	/**
	 Add the competition with the given name to the database

	 @param name
	 @return id of the newly added competition or id of existing
	 */
	public function addCompetition($name) {

		//Check if the competition isn't already in the database
		try {
			return $this -> getCompetition($name) -> getId();

		} catch (exception $e) {

		}

		//Query
		$query = "
			INSERT INTO Competition (name)
			VALUES (?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('s', $name)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this works always...


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
			return $this -> getTournament($name, $competitionId) -> getId();

		} catch (exception $e) {

		}

		if (!$this -> checkCompetitionExists($competitionId)) {

			return;
		}

		//Query
		$query = "
			INSERT INTO Tournament (name, competitionId)
			VALUES (?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('si', $name, $competitionId)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this works always...


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
		$sel = new \Selector('Tournament');
		$sel->filter([['name', '=', $name]]);
		$sel->filter([['competitionId', '=', $competitionId]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $this->resultToTournaments($result)[0];
	}

	/**
	 Check if the tournament exists

	 @param id

	 @return true if tournament exists
	 @return false if tournament doesn't exist

	 @exception When there is more than 1 tournament with that id
	 */
	public function checkTournamentExists($id) {
		$sel = new \Selector('Tournament');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireMaxCount($result, 1);

		return count($result) == 1;
	}

	/**
	 Get the competition with the given id

	 @param id
	 @return competition

	 @exception when no competition found with the given id
	 */
	public function getTournamentById($id) {
		$sel = new \Selector('Tournament');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$tournaments = $this->resultToTournaments($result);
		requireEqCount($tournaments, 1);

		return $tournaments[0];
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
			return $this -> getReferee($firstName, $lastName, $countryId) -> getId();

		} catch (exception $e) {
		}

		//Query
		$query = "
			INSERT INTO Referee (firstName, lastName, countryId)
			VALUES (?, ?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('ssi', $firstName, $lastName, $countryId)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...


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
		$sel = new \Selector('Referee');
		$sel->filter([['firstname', '=', $firstName]]);
		$sel->filter([['lastname', '=', $lastName]]);
		$sel->filter([['countryId', '=', $countryId]]);

		$result = $this->select($sel);
		$referees = $this->resultToReferees($result);
		requireEqCount($referees, 1);

		return $referees[0];
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
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('i', $id)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Store the result in the buffer
		$statement -> store_result();

		$numberOfResults = $statement -> num_rows;

		//Check if the correct number of results are returned from the database
		if ($numberOfResults > 1) {
			throw new exception('Corrupt database: multiple referee with the same name and country of origin');
		} else if ($numberOfResults < 1) {


			return false;
		} else {


			return true;

		}


	}

	/**
	 Get the referee with the given id

	 @param id
	 @return referee

	 @exception when no referee found with the given id
	 */
	public function getRefereeById($id) {
		$sel = new \Selector('Referee');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$referees = $this->resultToReferees($result);

		if(count($referees) != 1) {
			throw new exception('Could not find referee with id ' . $id);
		}

		return $referees[0];
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
			return $this -> getCoach($firstName, $lastName, $countryId) -> getId();

		} catch (exception $e) {
		}

		//Query
		$query = "
			INSERT INTO Coach (firstName, lastName, country)
			VALUES (?, ?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('ssi', $firstName, $lastName, $countryId)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...

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
		$sel = new \Selector('Coach');
		$sel->filter([['firstname', '=', $firstName]]);
		$sel->filter([['lastname', '=', $lastName]]);
		$sel->filter([['country', '=', $countryId]]);

		$result = $this->select($sel);
		$coaches = $this->resultToCoaches($result);
		requireEqCount($coaches, 1);

		return $coaches[0];
	}

	/**
	 check if a coach with the given id exists

	 @param id

	 @return true if coach exists
	 */
	public function checkCoachExists($id) {
		$sel = new \Selector('Coach');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$coaches = $this->resultToCoaches($result);

		return count($coaches) == 1;
	}

	/**
	 Get the coach with the given id

	 @param id
	 @return coach

	 @exception when no coach found with the given id
	 */
	public function getCoachById($id) {
		$sel = new \Selector('Coach');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$coaches = $this->resultToCoaches($result);
		requireEqCount($coaches, 1);

		return $coaches[0];
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

			if ($this -> checkTeamExists($teamId) && $this -> checkCoachExists($coachId)) {

				//Check if the coaches relation isn't already in the database
				try {
					return $this -> getCoaches($coachId, $teamId, $matchId) -> getId();

				} catch (exception $e) {

				}

				//Query
				$query = "
					INSERT INTO Coaches (coachId, teamId, matchId)
					VALUES (?, ?, ?);
				";

				$statement = $this->getStatement($query);

				//Bind parameters
				if (!$statement -> bind_param('iii', $coachId, $teamId, $matchId)) {
					throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
				}

				//Execute statement
				if (!$statement -> execute()) {
					throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
				}

				//Keep id of the last inserted row
				$id = $statement -> insert_id;
				//TODO Check if this always works...



				return $id;
			} else {

				return;
			}
		} catch(exception $e) {

			return;
		}
	}

	/**
	 Get the coacheses with the given id, team, match

	 @param coachId
	 @param teamId
	 @param matchId

	 @return Coaches

	 @exception when no coacheses found with the given id, team, match
	 */
	public function getCoaches($coachId, $teamId, $matchId) {
		$sel = new \Selector('Coaches');
		$sel->filter([['coachId', '=', $coachId]]);
		$sel->filter([['teamId', '=', $teamId]]);
		$sel->filter([['matchId', '=', $matchId]]);

		$result = $this->select($sel);
		$coacheses = $this->resultToCoacheses($result);
		requireEqCount($coacheses, 1);

		return $coacheses[0];
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
			return $this -> getTeam($name, $countryId) -> getId();

		} catch (exception $e) {

		}

		//Query
		$query = "
			INSERT INTO Team (name, country)
			VALUES (?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('si', $name, $countryId)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...


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
		$sel = new \Selector('Team');
		$sel->filter([['name', '=', $name]]);
		$sel->filter([['country', '=', $countryId]]);

		$result = $this->select($sel);
		$teams = $this->resultToTeams($result);
		requireEqCount($teams, 1);

		return $teams[0];
	}

	/**
	Get the team with the given id

	@param id

	@return team

	@exception when no team found with the given name and country
	*/
	public function getTeamById($id) {
		$sel = new \Selector('Team');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$teams = $this->resultToTeams($result);
		requireEqCount($teams, 1);

		return $teams[0];
	}

	/**
	 Check if a team with the given id exists

	 @param id

	 @return true if team exists
	 */
	public function checkTeamExists($id) {
		$sel = new \Selector('Team');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);

		return count($result) == 1;
	}

	/**
	 Add a new player to the database

	 @param first name
	 @param last name
	 @param country id
	 @param date of birth
	 @param height
	 @param weight
	 @param position
	 @param image url

	 @return id of the newly added player or id of existing
	 */
	public function addPlayer($firstName, $lastName, $countryId, $dateOfBirth, $height, $weight, $position) {

		//Check if the player isn't already in the database
		try {
			return $this -> getPlayer($firstName, $lastName, $countryId, $dateOfBirth, $height, $weight) -> getId();

		} catch (exception $e) {
		}

		//Query
		$query = "
			INSERT INTO Player (firstname, lastname, country, dateOfBirth, height, weight, position)
			VALUES (?, ?, ?, ?, ?, ?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('ssiiiis', $firstName, $lastName, $countryId, $dateOfBirth, $height, $weight, $position)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...


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
		$sel = new \Selector('Player');
		$sel->filter([['firstname', '=', $firstName]]);
		$sel->filter([['lastname', '=', $lastName]]);
		$sel->filter([['country', '=', $countryId]]);
		$sel->filter([['dateOfBirth', '=', $dateOfBirth]]);
		$sel->filter([['height', '=', $height]]);
		$sel->filter([['weight', '=', $weight]]);

		$result = $this->select($sel);
		$players = $this->resultToPlayers($result);
		requireEqCount($players, 1);

		return $players[0];
	}

	/**
	 Check if a player exists with a given ID

	 @param id
	 @return true if the player exists
	 @return false if the player doesn't exist

	 @exception When there are multiple players with the same ID
	 */
	public function checkPlayerExists($id) {
		$sel = new \Selector('Player');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		requireMaxCount($result, 1);

		return count($result) == 1;
	}

	/**
	 Get the player with the given id

	 @param id
	 @return player

	 @exception when no player found with the given id
	 */
	public function getPlayerById($id) {
		$sel = new \Selector('Player');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$players = $this->resultToPlayers($result);
		requireEqCount($players, 1);

		return $players[0];
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
			return $this -> getGoal($playerId, $time, $matchId) -> getId();

		} catch (exception $e) {
		}

		if (!$this -> checkPlayerExists($playerId) || !$this -> checkMatchExists($matchId)) {

			return;
		}

		//Query
		$query = "
			INSERT INTO `Goal` (playerId, matchId, time)
			VALUES (?, ?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('iii', $playerId, $matchId, $time)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...

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
		$sel = new \Selector('Goal');
		$sel->filter([['playerId', '=', $playerId]]);
		$sel->filter([['time', '=', $time]]);
		$sel->filter([['matchId', '=', $matchId]]);

		$result = $this->select($sel);
		$goals = $this->resultToGoals($result);
		requireEqCount($goals, 1);

		return $goals[0];
	}

	/**
	Get the goal with the id

	@param id

	@return goal

	@exception when no goal found with the given id
	*/
	public function getGoalById($id) {
		$sel = new \Selector('Goal');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$goals = $this->resultToGoals($result);
		requireEqCount($goals, 1);

		return $goals[0];
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
			return $this -> getMatch($teamA, $teamB, $refereeId, $date, $tournamentId) -> getId();

		} catch (exception $e) {
		}

		if (!$this -> checkTeamExists($teamA) || !$this -> checkTeamExists($teamB) || !$this -> checkTournamentExists($tournamentId)) {

			throw new exception('Error creating match, check integrity');
			return;
		}

		//Create a score for this match and save the id of this score
		$scoreId = null;
		if (($scoreA != -1) and ($scoreB != -1))
			$scoreId = $this -> addScore($scoreA, $scoreB);

		//Query
		$query = "
			INSERT INTO `Match` (teamA, teamB, tournamentId, refereeId, date, scoreId)
			VALUES (?, ?, ?, ?, ?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('iiiiii', $teamA, $teamB, $tournamentId, $refereeId, $date, $scoreId)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...

		return $id;
	}

	public function getMatch($teamA, $teamB, $refereeId, $date, $tournamentId) {
		$sel = new \Selector('Match');
		$sel->filter([['teamA', '=', $teamA]]);
		$sel->filter([['teamB', '=', $teamB]]);
		$sel->filter([['refereeId', '=', $refereeId]]);
		$sel->filter([['date', '=', $date]]);
		$sel->filter([['tournamentId', '=', $tournamentId]]);

		$result = $this->select($sel);
		$matches = $this->resultToMatches($result);
		requireEqCount($matches, 1);

		return $matches[0];
	}


	/**
	 Remove a match with the given id

	 @param id
	*/
	public function removeMatch($id) {

		//Query
		$query = "
			REMOVE FROM `Match` WHERE id = ?;
		";

		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('i', $id)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

	}


	/**
	 Get the match with the given id

	 @param id
	 @return match

	 @exception when no competition found with the given id
	 */
	public function getMatchById($id) {
		$sel = new \Selector('Match');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$matches = $this->resultToMatches($result);
		requireEqCount($matches, 1);

		return $matches[0];
	}

	/**
	 Check if a match exists with a given ID

	 @param id
	 @return true if the match exists
	 @return false if the match doesn't exist

	 @exception When there are multiple match with the same ID
	 */
	public function checkMatchExists($id) {
		$sel = new \Selector('Match');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);

		return count($result) == 1;
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

			return $this -> getPlaysMatchInTeam($playerId, $matchId, $teamId, $number);
		} catch (exception $e) {
		}

		if (!$this -> checkMatchExists($matchId)) {
			throw new exception("Bad reference: player $playerId, team $teamId, match $matchId");
			return;
		}

		//Query
		$query = "
			INSERT INTO `PlaysMatchInTeam` (playerId, teamId, matchId, number)
			VALUES (?, ?, ?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('iiii', $playerId, $teamId, $matchId, $number)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...

		return $id;
	}

	public function getPlaysMatchInTeam($playerId, $matchId, $teamId, $number) {
		$sel = new \Selector('PlaysMatchInTeam');
		$sel->filter([['playerId', '=', $playerId]]);
		$sel->filter([['number', '=', $number]]);
		$sel->filter([['teamId', '=', $teamId]]);
		$sel->filter([['matchId', '=', $matchId]]);

		$result = $this->select($sel);
		$playsMatchInTeams = $this->resultToPlaysMatchInTeams($result);
		requireEqCount($playsMatchInTeams, 1);

		return $playsMatchInTeams[0];
	}



	public function getTeamInMatch($teamId, $matchId) {

		//Query
		$query = "
			SELECT * FROM `PlaysMatchInTeam`
			WHERE teamId = ? AND
			matchId = ?
			GROUP By playerId;
		"; //TODO FIX THE DUPLICATES IN THE OTHER FUNCTIONS!!!

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('ii', $teamId, $matchId)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Store the result in the buffer
		$statement -> store_result();


		//Bind return values
		$statement->bind_result($id, $playerId, $number, $teamId, $matchId);


		$out = array();

		//Fetch the rows of the return values
		while ($statement -> fetch()) {

			//Create new Player object
			$player = $this->getPlayerById($playerId);
			$player->number = $number;
			$out[] = $player;


		}


		return $out;

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
			return $this -> getPlaysInId($playerId, $teamId);

		} catch (exception $e) {
		}

		if (!$this -> checkTeamExists($teamId) || !$this -> checkPlayerExists($playerId)) {
			throw new exception("Bad reference");
			return;
		}

		//Query
		$query = "
			INSERT INTO `PlaysIn` (playerId, teamId)
			VALUES (?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('ii', $playerId, $teamId)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...




		return $id;
	}


	/**
	 Return the id of a PlaysIn row, or throw an exception

	 @param id of player
	 @param id of team
	 */
	public function getPlaysInId($playerId, $teamId) {

		$sel = new \Selector('PlaysIn');
		$sel->filter([['playerId', '=', $playerId]]);
		$sel->filter([['teamId', '=', $teamId]]);

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['id'];
	}




	public function getPlayersInTeam($teamId) {

		$sel = new \Selector('PlaysIn');
		$sel->filter([['teamId', '=', $teamId]]);
		$sel->join('Player', 'playerId', 'id');
		$sel->select('Player.*');

		$result = $this->select($sel);

		return $this->resultToPlayers($result);
	}



	/**
	 Clear part of the PlaysIn table, so that it can be refilled with more recent information
	 */
	public function removePlayersFromTeam($teamId) {

		//Query
		$query = "
			DELETE FROM `PlaysIn`
			WHERE teamId = ?;
		";

		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('i', $teamId)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
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
			return $this -> getFoulCard($playerId, $matchId, $time, $color) -> getId();

		} catch (exception $e) {
		}

		if (!$this -> checkMatchExists($matchId)) {

			throw new exception("Match Id '$matchId' doesn't exist!");

		} elseif (!$this -> checkPlayerExists($playerId)) {

			throw new exception("Player Id '$playerId' doesn't exist!");

		}

		//Query
		$query = "
			INSERT INTO Cards (playerId, matchId, color, time)
			VALUES (?, ?, ?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('iiii', $playerId, $matchId, $color, $time)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...




		return $id;

	}

	public function getFoulCard($playerId, $matchId, $time, $color) {
		$sel = new \Selector('Cards');
		$sel->filter([['playerId', '=', $playerId]]);
		$sel->filter([['matchId', '=', $matchId]]);
		$sel->filter([['color', '=', $color]]);
		$sel->filter([['time', '=', $time]]);

		$result = $this->select($sel);
		$cards = $this->resultToCards($result);
		requireEqCount($cards, 1);

		return $cards[0];
	}

	public function getFoulCardById($id) {
		$sel = new \Selector('Cards');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$cards = $this->resultToCards($result);
		requireEqCount($cards, 1);

		return $cards[0];
	}

	/**
	 Add a new score to the database

	 @param team A
	 @param team B

	 @return id of the newly added score or id of existing
	 */
	public function addScore($teamA, $teamB) {

		//Check if the score isn't already in the database
		try {
			return $this -> getScore($teamA, $teamB) -> getId();

		} catch (exception $e) {
		}

		//Query
		$query = "
			INSERT INTO Score (teamA, teamB)
			VALUES (?, ?);
		";

		//Prepare statement
		$statement = $this->getStatement($query);

		//Bind parameters
		if (!$statement -> bind_param('ii', $teamA, $teamB)) {
			throw new exception('Binding parameters failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Execute statement
		if (!$statement -> execute()) {
			throw new exception('Execute failed: (' . $statement -> errno . ') ' . $statement -> error);
		}

		//Keep id of the last inserted row
		$id = $statement -> insert_id;
		//TODO Check if this always works...


		return $id;
	}

	public function getScore($teamA, $teamB) {
		$sel = new \Selector('Score');
		$sel->filter([['teamA', '=', $teamA]]);
		$sel->filter([['teamB', '=', $teamB]]);

		$result = $this->select($sel);
		$scores = $this->resultToScores($result);

		requireEqCount($scores, 1);

		return $scores[0];
	}

	public function getScoreById($id) {
		$sel = new \Selector('Score');
		$sel->filter([['id', '=', $id]]);

		$result = $this->select($sel);
		$scores = $this->resultToScores($result);
		if(count($scores) != 1) {
			throw new exception('Could not find score with id ' . $id);
		}

		return $scores[0];
	}

	public function getTotalNumberOfGoals($playerId) {
		$sel = new \Selector('Goal');
		$sel->filter([['playerId', '=', $playerId]]);
		$sel->count();

		$result = $this->select($sel);
		if(count($result) != 1) {
			throw new exception('Could not count total goals for player ' . $playerId);
		}

		return $result[0]['COUNT(*)'];
	}

	public function getTotalNumberOfMatches($playerId) {
		$sel = new \Selector('PlaysMatchInTeam');
		$sel->filter([['playerId', '=', $playerId]]);
		$sel->count();

		$result = $this->select($sel);
		if(count($result) != 1) {
			throw new exception('Could not count total matches for player ' . $playerId);
		}

		return $result[0]['COUNT(*)'];
	}

	public function getTotalNumberOfCards($playerId) {
		$sel = new \Selector('Cards');
		$sel->filter([['playerId', '=', $playerId]]);
		$sel->count();

		$result = $this->select($sel);
		requireEqCount($result, 1);

		return $result[0]['COUNT(*)'];
	}



	public function getCoachForTeamAndMatch($teamId, $matchId) {
			$sel = new \Selector('Coaches');
			$sel->filter([['teamId', '=', $teamId]]);
			$sel->filter([['matchId', '=', $matchId]]);
			$sel->join('Coach', 'coachId', 'id');
			$sel->select(['Coach.*']);

			$result = $this->select($sel);
			$coaches = $this->resultToCoaches($result);
			if(count($coaches) != 1) {
				throw new exception('Could not find coach for team ' . $teamId . ' and match ' . $matchId);
			}

			return $coaches[0];
		}



	public function getCoachForTeam($teamId) {

		$sel = new \Selector('Coaches');
		$sel->filter([['Coaches.teamId', '=', $teamId]]);
		$sel->order('matchId', 'DESC');
		$sel->join('Coach', 'coachId', 'id');
		$sel->select(['Coach.*']);

		$result = $this->select($sel);

		$coaches = $this->resultToCoaches($result);

		if(sizeof($coaches) < 1) {
			return NULL;
		}
		else {
			return $coaches[0];
		}

	}




	/**
	Returns all tournaments of the competition

	@return tournaments
	*/
	public function getTournamentsInCompetition($competitionId) {
		$sel = new \Selector('Tournament');
		$sel->filter([['competitionId', '=', $competitionId]]);


		$result = $this->select($sel);


		return $this->resultToTournaments($result);
	}

	/**
	Returns all matches of the tournament

	@return matches
	*/
	public function getMatchesInTournament($tournamentId) {
		$sel = new \Selector('Match');
		$sel->filter([['tournamentId', '=', $tournamentId]]);

		$result = $this->select($sel);

		return $this->resultToMatches($result);
	}

	private function resultToCompetitions($result) {
		$competitions = array();

		foreach($result as $competition) {
			array_push($competitions, new Competition($competition['id'], $competition['name'], $this));
		}

		return $competitions;
	}

	private function resultToTournaments($result) {
		$tournaments = array();

		foreach($result as $tournament) {
			array_push($tournaments, new Tournament($tournament['id'], $tournament['name'], $tournament['competitionId'], $this));
		}

		return $tournaments;
	}

	private function resultToTeams($result) {
		$teams = array();

		foreach($result as $team) {
			array_push($teams, new Team($team['id'], $team['name'], $team['country'], $this));
		}

		return $teams;
	}

	private function resultToReferees($result) {
		$referees = array();

		foreach($result as $referee) {
			array_push($referees, new Referee($referee['id'], $referee['firstname'], $referee['lastname'], $referee['countryId'], $this));
		}

		return $referees;
	}

	private function resultToMatches($result) {
		$matches = array();

		foreach($result as $match) {
			array_push($matches, new Match($match['id'], $match['teamA'], $match['teamB'],
						$match['tournamentId'], $match['refereeId'], $match['date'], $match['scoreId'],
						$this));
		}


		return $matches;
	}

	private function resultToGoals($result) {
		$goals = array();

		foreach($result as $goal) {
			array_push($goals, new Goal($goal['id'], $goal['playerId'], $goal['matchId'], $goal['time'], $this));
		}


		return $goals;
	}

	private function resultToCoaches($result) {
		$coaches = array();

		foreach($result as $coach) {
			array_push($coaches, new Coach($coach['id'], $coach['firstname'], $coach['lastname'], $coach['country'], $this));
		}


		return $coaches;
	}

	private function resultToCoacheses($result) {
		$coacheses = array();

		foreach($result as $coaches) {
			array_push($coacheses, new Coaches($coaches['id'], $coaches['teamId'], $coaches['coachId'], $coaches['date']));
		}


		return $coacheses;
	}

	private function resultToPlayers($result) {
		$players = array();

		foreach($result as $player) {
			array_push($players, new Player($player['id'], $player['firstname'], $player['lastname'], $player['country'],
											$player['dateOfBirth'], $player['height'], $player['weight'], $player['position'], $this));
		}


		return $players;
	}

	private function resultToScores($result) {
		$scores = array();

		foreach($result as $score) {
			array_push($scores, new Score($score['id'], $score['teamA'], $score['teamB']));
		}


		return $scores;
	}

	private function resultToCountries($result) {
		$countries = array();

		foreach($result as $country) {
			array_push($countries, new Country($country['id'], $country['name']));
		}


		return $countries;
	}

	private function resultToCards($result) {
		$cards = array();

		foreach($result as $card) {
			array_push($cards, new Card($card['id'], $card['playerId'], $card['matchId'], $card['color'],
										$card['time'], $this));
		}


		return $cards;
	}

	private function resultToPlaysMatchInTeams($result) {
		$playsMatchInTeams = array();

		foreach($result as $pmit) {
			array_push($playsMatchInTeams, new PlaysMatchInTeam($pmit['id'],
						$pmit['playerId'], $pmit['teamId'], $pmit['matchId'],
						$pmit['number'], $this));
		}


		return $playsMatchInTeams;
	}

	private function resultToUsers($result) {
		$users = array();

		foreach($result as $user) {
			array_push($users, new User($user['id']));
		}


		return $users;
	}

	/**
	Returns all competitions

	@return competitions
	*/
	public function getAllCompetitions() {
		$sel = new \Selector('Competition');

		$result = $this->select($sel);


		return $this->resultToCompetitions($result);
	}

	/**
	Returns amount of matches won by player

	@return amount of matches
	*/
	public function getTotalMatchesWonByPlayer($playerId) {
		//Query
		$query = "
			SELECT COUNT(*) FROM `PlaysMatchInTeam`
			JOIN `Match` ON `Match`.id = matchId
			JOIN `Score` ON `Score`.id = scoreId
			WHERE playerId = ? AND
			((teamId = `Match`.teamA AND `Score`.teamA > `Score`.teamB) OR
			 (teamID = `Match`.teamB AND `Score`.teamB > `Score`.teamA))
		";

		//Prepare statement
		$statement = $this->getStatement($query);

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


		$numberOfResults = $statement->num_rows;

		if($numberOfResults != 1) {
			throw new exception('Could not count the matches the player has won');
		}

		$statement->bind_result($amount);

		while ($statement->fetch()) {

			return $amount;

		}

		throw new exception('Error while counting the matches the player has won');
	}

}
?>
