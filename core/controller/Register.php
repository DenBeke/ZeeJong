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
			if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['password2']) || !isset($_POST['email'])) {
				return;
			}

			$username = $_POST['username'];
			$password = $_POST['password'];
			$password2 = $_POST['password2'];

			$emailAddress = $_POST['email'];

			$this -> register($username, $password, $password2, $emailAddress);
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
			$database = new \Database;
			// Test if logged in
			if (isset($_SESSION['userID']) and $database -> doesUserExist($_SESSION['userID'])) {
				$this -> registerMessage = '	<div class="alert alert-danger"><strong>You are already logged in.</strong></div>';
				return false;
			}

			// Test if username already exists
			if ($database -> doesUserNameExist($username)) {
				$this -> registerMessage = '<div class="alert alert-danger"><strong>Username already exists, please choose a different one.</strong></div>';
				return false;
			}

			// Test if username is too short
			if (strlen($username) <= 3) {
				$this -> registerMessage = '<div class="alert alert-danger"><strong>Your username must be longer than 3 characters.</strong></div>';
				return false;
			}

			// Test if passwords are the same
			if ($password != $password2) {
				$this -> registerMessage = '<div class="alert alert-danger"><strong>Passwords do not match.</strong></div>';
				return false;
			}

			// Test if password is too short
			if (strlen($password) <= 3) {
				$this -> registerMessage = '<div class="alert alert-danger"><strong>Your password must be longer than 3 characters.</strong></div>';
				return false;
			}

			// Test if email address is valid
			if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
				$this -> registerMessage = '<div class="alert alert-danger"><strong>Your emailaddress is invalid.</strong></div>';
				return false;
			}

			$salt = $this -> generateSalt();
			$hashedPassword = hashPassword($password, $salt);
			$id = $database -> registerUser($username, $salt, $hashedPassword, $emailAddress);
			$this -> registerMessage = '<div class="alert alert-success">Congratulations, account was successfully created.</strong></div>';
			return true;
		}

	}

}
?>
