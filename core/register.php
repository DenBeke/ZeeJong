<?php
/*
File to register new users
*/
require_once(dirname(__FILE__) . '/config.php');	// Require config file containing configuration of the database
require_once(dirname(__FILE__) . '/database.php');	// Require the database file

class Register {
	/**
	@brief Constructor of the register object.
	
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
	Generate a salt
	*/
	private function generateSalt() {
		return uniqid(rand(0, 1000000));
	}
	
	/**
	Hash a password with a given salt
	*/
	private function hashPassword($password,$salt) {
		$hash = crypt($password, $salt);
		return $hash;
	}

	/**
	Register a user
	*/
	public function registerUser($username, $password, $emailAddress) {
// TODO	Make sure username is available!
		$d = new Database;
		$salt = $this->generateSalt();
		$hashedPassword = $this->hashPassword($password,$salt);
		$id = $d->registerUser($username, $salt,$hashedPassword, $emailAddress);
	}
}

$r = new Register;
$r->registerUser('Alexander','passw','test@test.com');
?>
