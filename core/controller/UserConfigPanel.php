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
		private $oldPass;
		private $newEmail;
		private $newPassword;

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
			if (!isset($_POST['oldPass']) || !isset($_POST['newEmail']) || !isset($_POST['newPass']) || !isset($_POST['newPass2'])) {
				return;
			}
			$oldPass = $_POST['oldPass'];
			$newEmail = $_POST['newEmail'];
			$newPassword = $_POST['newPass'];
			$newPassword = $_POST['newPass2'];

			$this -> register($username, $password, $password2, $emailAddress);
		}

	}

}
?>
