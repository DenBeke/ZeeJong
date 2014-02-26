<?php
/*
 File to register new users
 */
require_once (dirname(__FILE__) . '/config.php');
// Require config file containing configuration of the database
require_once (dirname(__FILE__) . '/database.php');
// Require the database file
require_once (dirname(__FILE__) . '/functions.php');

class Register {
	private $message;
	private $db;

	/**
	 * Constructor
	 */
	public function __construct() {
		$db = new Database;
	}

	/**
	 * Get the current message
	 */
	public function getMessage() {
		return $message;
	}

	/**
	 * Generate a salt
	 */
	private function generateSalt() {
		return uniqid(rand(0, 1000000));
	}

	/**
	 * Register a user
	 */
	public function registerUser($username, $password, $password2, $emailAddress) {
		// Test if logged in
		if (isset($_SESSION['userID']) and $database -> doesUserExist($_SESSION['userID'])) {
			$this -> message = 'You are already logged in.';
			return false;
		}

		// Test if username already exists
		if ($db -> doesUserExist($username)) {
			$this -> message = 'Username already exists, please choose a different one.';
			return false;
		}

		// Test if passwords are the same
		if ($password != $password2) {
			$this -> message = 'Passwords do not match.';
			return false;
		}

		$salt = generateSalt();
		$hashedPassword = hashPassword($password, $salt);
		$id = $db -> registerUser($username, $salt, $hashedPassword, $emailAddress);
		$this -> message = 'Congratulations, account was successfully created.';
	}

}

if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['password2']) || !isset($_POST['email'])) {
	exit();
}

$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

$emailAddress = $_POST['email'];


$register->registerUser($username, $password, $password2, $emailAddress);
?>
