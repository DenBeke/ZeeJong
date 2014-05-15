<?php
/*
 Admin Controller

 Created May 2014
 */

namespace Controller {

	require_once (dirname(__FILE__) . '/Controller.php');

	class AdminUsers extends Controller {

		public $page = 'admin-users';

		public $title;
		private $errorMessage;
		private $successMessage;

		public function __construct() {
			$this -> theme = 'admin-users.php';
			$this -> title = 'Admin - Users - ' . Controller::siteName;
			if (!isAdmin()) {
				return;
			}
			global $database;
			if (isset($_POST['nameBan'])) {
				// ban the user
				if (!$database -> doesUserNameExist($_POST['nameBan'])) {
					$this -> errorMessage = $this -> errorMessage . "The user does not exist." . "\r\n";
				} else if ($database -> getUserName($_SESSION['userID']) == $_POST['nameBan']) {
					$this -> errorMessage = $this -> errorMessage . "You can not ban yourself." . "\r\n";
				} else if ($database -> isAdmin($database -> getUserId($_POST['nameBan']))) {
					$this -> errorMessage = $this -> errorMessage . "You can not ban an admin." . "\r\n";
				} else {
					$database -> removeUser($database -> getUserId($_POST['nameBan']));
					$this -> successMessage = $this -> successMessage . "The user was successfully banned." . "\r\n";
				}
			}

			if (isset($_POST['nameMakeAdmin'])) {
				// make the user admin
				if (!$database -> doesUserNameExist($_POST['nameMakeAdmin'])) {
					$this -> errorMessage = $this -> errorMessage . "The user does not exist." . "\r\n";
				} else if ($database -> isAdmin($database -> getUserId($_POST['nameMakeAdmin']))) {
					$this -> errorMessage = $this -> errorMessage . "The user is already an admin." . "\r\n";
				} else {
					$database -> makeAdmin($database -> getUserId($_POST['nameMakeAdmin']));
					$this -> successMessage = $this -> successMessage . "The user was successfully made an admin." . "\r\n";
				}
			}

			if (isset($_POST['nameRemoveAdmin'])) {
				// remove admin rights from user
				if (!$database -> doesUserNameExist($_POST['nameRemoveAdmin'])) {
					$this -> errorMessage = $this -> errorMessage . "The user does not exist." . "\r\n";
				} else if ($database -> getUserName($_SESSION['userID']) == $_POST['nameRemoveAdmin']) {
					$this -> errorMessage = $this -> errorMessage . "You can not remove your own admin rights." . "\r\n";
				} else {
					$database -> removeAdmin($database -> getUserId($_POST['nameRemoveAdmin']));
					$this -> successMessage = $this -> successMessage . "The user was successfully stripped from his admin rights." . "\r\n";
				}
			}

		}

		public function getErrorMessage() {
			return $this -> errorMessage;
		}

		public function getSuccessMessage() {
			return $this -> successMessage;
		}

	}

}
?>
