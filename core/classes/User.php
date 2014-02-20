<?php
require_once(dirname(__FILE__) . '/../config.php');

/**
@brief Class containing a user

The class contains the following information:
	-id (key)
	-screenName (key)
	-firstName
	-lastName
	-phoneNr
	-streetName
	-houseNr
	-city
	-country
	-birthDate
	-gender
	-balans
	-joinDate
	-emailAddress
	-password (hashed)
	-avatar
*/

class User {
	private $id;
	private $screenName;
	private $firstName;
	private $lastName;
	private $phoneNr;
	private $streetName;
	private $houseNr;
	private $city;
	private $country;
	private $birthDate;
	private $gender;
	private $balans;
	private $joinDate;
	private $emailAddress;
	private $password;
	private $avatar;

	/**
	Constructor

	@param id The ID of the user
	*/
	public function __construct($id) {
		$this->id = $id;
	}

	/**
	Get the ID of the user

	@return the id of the user
	*/
	public function getID() {
		return $this->id;
	}

	/**
	Get the username of the user

	@return the username of the user
	*/
	public function getUserName() {
		//Connect to the database
		$this->link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		
		//Check the connection
		if (mysqli_connect_errno()) {
			$error = mysqli_connect_error();
			throw new Exception("Connect failed: $error");
		}
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
		if(!$statement->bind_param('i', $this->id)){
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
			throw new exception('Corrupt database: multiple users with same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no user with the given id');
		}

		//Bind return values
		$statement->bind_result($username);
		//Fetch the rows of the return values
		$statement->fetch();
		//Close the statement		
		$statement->close();
		return $username;
	}

	/**
	Get the hashed password of the user

	@return the hashed password of the user
	*/
	public function getHash() {
		//Connect to the database
		$this->link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		
		//Check the connection
		if (mysqli_connect_errno()) {
			$error = mysqli_connect_error();
			throw new Exception("Connect failed: $error");
		}
		//Query
		$query = "
			SELECT password FROM User
			WHERE id = ?;
		";
		
		//Prepare statement
		if(!$statement = $this->link->prepare($query)) {
			throw new exception('Prepare failed: (' . $this->link->errno . ') ' . $this->link->error);
		}
		
		//Bind parameters
		if(!$statement->bind_param('i', $this->id)){
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
			throw new exception('Corrupt database: multiple users with same id');
		}
		else if($numberOfResults < 1) {
			throw new exception('Error, there is no user with the given id');
		}

		//Bind return values
		$statement->bind_result($password);
		//Fetch the rows of the return values
		$statement->fetch();
		//Close the statement		
		$statement->close();
		return $password;
	}


}

?>




