<?php
require_once (dirname(__FILE__) . '/../database.php');

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
	private $d;
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
		$this -> id = $id;
		$this -> d = new Database;
	}

	/**
	 Get the ID of the user

	 @return the id of the user
	 */
	public function getID() {
		return $this -> id;
	}

	/**
	 Get the username of the user

	 @return the username of the user
	 */
	public function getUserName() {
		return $this -> d -> getUserName($this -> id);
	}

	/**
	 Get the hashed password of the user

	 @return the hashed password of the user
	 */
	public function getHash() {
		return $this -> d -> getUserPasswordHash($this -> id);
	}

	/**
	 Get the salt of the user

	 @return the salt password of the user
	 */
	public function getSalt() {
		return $this -> d -> getUserPasswordSalt($this -> id);
	}

	/**
	 Get the email address of the user

	 @return the emailaddress
	 */
	public function getMail() {
		return $this -> d -> getUserMail($this -> id);
	}

	/**
	 Change the emailaddress of the user

	 @param the new email address
	 */
	public function setEmail($newMail) {
		return $this -> d -> setUserMail($this -> id, $newMail);
	}

	/**
	 Change the hashed password of the user

	 @param the new hashed password
	 */
	public function setHash($newHash) {
		return $this -> d -> setUserHash($this -> id, $newHash);
	}

	/**
	 Change the password salt of the user

	 @param the new salt
	 */
	public function setSalt($newSalt) {
		return $this -> d -> setUserSalt($this -> id, $newSalt);
	}

}
?>