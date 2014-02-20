<?php


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
	*/
	public function getID() {
		return $this->id;
	}
	/**
	Get the screenname of the user
	*/
	public function getScreenName() {
		$screenName = mysql_query("SELECT screenName FROM secure_login WHERE id = $id"); 
		return $screenName;
	}
}

?>




