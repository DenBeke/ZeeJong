<?php
/*
Login file allowing users to log in
*/
require_once(dirname(__FILE__) . '/config.php');	// Require config file containing configuration of the database
require_once(dirname(__FILE__) . '/database.php');	// Require the database file
require_once(dirname(__FILE__) . '/classes/User.php');	// We need the user class file

class Login {
	/**
	@brief Constructor of the login object.
	
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
	Hash a password with a given salt
	*/
	private function hashPassword($password,$salt) {
		$hash = crypt($password, $salt);
		return $hash;
	}


	public function login($username, $password) {
		$d = new Database;
		$user = $d->getUser($username);
		if($this->hashPassword($password,$user->getHash()) == $user->getHash()){
			echo "User logged in";
		}
		
	}
}
$l = new Login;
$l->login('Alexander','passw');

?>

