<?php
/*
 File to register new users
 */

namespace Controller {

	require_once (dirname(__FILE__) . '/../config.php');
	// Require config file containing configuration of the database
	require_once (dirname(__FILE__) . '/../database.php');
	// Require the database file
	require_once (dirname(__FILE__) . '/../classes/User.php');
	// We need the user class file
	require_once (dirname(__FILE__) . '/../functions.php');
	require_once (dirname(__FILE__) . '/Controller.php');

	class Register extends Controller {

		public $page = 'register';
		public $user;
		private $registerMessage;
		private $template = 'register.php';

		/**
		 Render the template part of the view

		 @exception theme file does not exist
		 */
		public function template() {

			if (is_array($this -> data)) {
				extract($this -> data);
			}

			if (file_exists($this -> themeDir . '/' . $this -> template)) {
				include ($this -> themeDir . '/' . $this -> template);
			}

		}

		/**
		 * Constructor
		 */
		public function __construct() {
			$db = new \Database;
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
		public function register($username, $password, $password2, $emailAddress) {
			// Test if logged in
			if (isset($_SESSION['userID']) and $database -> doesUserExist($_SESSION['userID'])) {
				$this -> registerMessage = 'You are already logged in.';
				return false;
			}

			// Test if username already exists
			if ($db -> doesUserExist($username)) {
				$this -> registerMessage = 'Username already exists, please choose a different one.';
				return false;
			}

			// Test if passwords are the same
			if ($password != $password2) {
				$this -> registerMessage = 'Passwords do not match.';
				return false;
			}

			$salt = generateSalt();
			$hashedPassword = hashPassword($password, $salt);
			$id = $db -> registerUser($username, $salt, $hashedPassword, $emailAddress);
			$this -> registerMessage = 'Congratulations, account was successfully created.';
		}

	}
/*
	if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['password2']) || !isset($_POST['email'])) {

	} else {

		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];

		$emailAddress = $_POST['email'];

		$this -> registerUser($username, $password, $password2, $emailAddress);

	}
*/
 
}
?>
