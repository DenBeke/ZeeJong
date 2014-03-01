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
			if (!isset($_SESSION['userID'])) {
				return;
			}
			if (!isset($_POST['oldPass']) && !isset($_POST['newEmail']) && !isset($_POST['newPassword']) && !isset($_POST['newPassword2'])) {
				return;
			}

			$d = new \Database;
			// The user with the specific ID must exist
			if (!$d -> doesUserExist($_SESSION['userID'])) {
				return;
			}
			$this -> user = new \User($_SESSION['userID']);

			$this -> changeSettings();
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
		private function changeSettings() {
			if (!isset($_POST['oldPass'])) {
				$this -> configMessage = '	<div class="alert alert-danger"><strong>You must give your current password.</strong></div>';
				return false;
			}
			$oldPass = $_POST['oldPass'];
			// Verify old password
			if (!(hashPassword($oldPass, $this -> user -> getSalt()) == $this -> user -> getHash())) {
				$this -> configMessage = '	<div class="alert alert-danger"><strong>Your current password is incorrect.</strong></div>';
				return false;
			}

			if (isset($_POST['newEmail'])) {
				$newEmail = $_POST['newEmail'];
				if (strlen($newEmail) > 0) {
					// Test if the new mail address is valid
					if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
						$this -> configMessage = '<div class="alert alert-danger"><strong>Your new emailaddress is invalid.</strong></div>';
						return false;
					}
					// Change the emailaddress
					$this -> user -> setEmail($newEmail);
				}
			}
			if (isset($_POST['newPassword']) && isset($_POST['newPassword2'])) {
				$newPassword = $_POST['newPassword'];
				$newPassword2 = $_POST['newPassword2'];
				if ($newPassword != $newPassword2) {
					// Test if new passwords are same
					$this -> configMessage = '<div class="alert alert-danger"><strong>New passwords do not match.</strong></div>';
				} else {
					if (strlen($newPassword) > 0 && strlen($newPassword) < 3) {
						// New password was set but too short
						$this -> configMessage = '<div class="alert alert-danger"><strong>New password has to be at least 3 characters long.</strong></div>';
						return false;
					}
					if (strlen($newPassword) >= 3) {
						// New password can be set
						$newSalt = $this -> generateSalt();
						$newHashedPassword = hashPassword($newPassword, $newSalt);
						$this -> user -> setHash($newHashedPassword);
						$this -> user -> setSalt($newSalt);
					}
				}
			}
			$this -> configMessage = '<div class="alert alert-success">New settings were successfully saved.</strong></div>';
			return true;
		}

	}

}
?>
