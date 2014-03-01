<?php
/*
 File to change user settings
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

	class UserConfigPanel extends Controller {

		public $page = 'configPanel';
		private $template = 'UserConfigPanel.php';
		public $configMessage;
		private $user;
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
			// Variables have to be set
			if (!isset($_POST['oldPass']) || !isset($_POST['newEmail']) || !isset($_POST['newPass']) || !isset($_POST['newPass2']) || !isset($_SESSION['userID'])) {
				return;
			}
			$d = new \Database;
			// The user with the specific ID must exist
			if (!$d -> doesUserExist($_SESSION['userID'])) {
				return;
			}
			$oldPass = $_POST['oldPass'];
			$newEmail = $_POST['newEmail'];
			$newPassword = $_POST['newPass'];
			$newPassword = $_POST['newPass2'];
			$user = new User($_SESSION('userID'));

			$this -> changeSettings($oldPass, $newEmail, $newPassword, $newPassword2);
		}

		/**
		 * Generate a salt
		 */
		private function generateSalt() {
			return uniqid(rand(0, 1000000));
		}

		/**
		 * Change the settings
		 */
		private function changeSettings($oldPass, $newEmail, $newPassword, $newPassword2) {
			// Verify old password
			if (!hashPassword($oldPass, $user -> getSalt()) == $user -> getHash()) {
				$this -> configMessage = '	<div class="alert alert-danger"><strong>Your old password is incorrect.</strong></div>';
				return false;
			}
			if (strlen($newEmail) > 0) {
				// Test if the new mail address is valid
				if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
					$this -> configMessage = '<div class="alert alert-danger"><strong>Your new emailaddress is invalid.</strong></div>';
					return false;
				}
				// Change the emailaddress

			}
		}

	}

}
?>
