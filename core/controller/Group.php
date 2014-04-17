<?php
/*
 placeBet Controller

 Created March 2014
 */

namespace Controller {
	require_once (dirname(__FILE__) . '/../database.php');
	// Require the database file
	require_once (dirname(__FILE__) . '/Controller.php');
	// We need the group class file
	require_once (dirname(__FILE__) . '/../classes/Group.php');

	class Group extends Controller {

		public $title;
		private $groupId;
		private $errorMessage;
		private $group;

		public function __construct() {
			global $database;
			$this -> theme = 'group.php';
			$this -> title = 'Group - ' . Controller::siteName;

			// Test if logged in
			if (!isset($_SESSION['userID'])) {
				return;
			}
			if (!$database -> doesUserExist($_SESSION['userID'])) {
				return;
			}
			if (isset($_POST['groupName'])) {
				$this -> groupId = $database -> getGroupId($_POST['groupName']);
				$this -> group = new \Group($this -> groupId, $database);
			}
			if (isset($_POST['userToRemove'])) {
				$this -> removeUser($_POST['userToRemove']);
			}
		}

		/**
		 Call GET methode with parameters

		 @param params
		 */
		public function GET($args) {
			if (!isset($args[1])) {
				throw new \exception('No group name was given');
				return;
			}
			$this -> args = $args[1];

			global $database;
			if (!$database -> doesGroupNameExist($args)) {
				$this -> errorMessage = $this -> errorMessage . "This group does not exist." . "\r\n";
				return;
			}
			$groupId = $database -> getGroupId($this -> args);
			if (!$database -> isUserMemberOfGroup($_SESSION['userID'], $groupId)) {
				$this -> errorMessage = $this -> errorMessage . "You are not a member of this group." . "\r\n";
				return;
			}

			$this -> groupId = $database -> getGroupId($args);
			$this -> group = new \Group($this -> groupId, $database);

		}

		/**
		 Get the error message

		 @return the error message
		 */
		public function getErrorMessage() {
			return $this -> errorMessage;
		}

		/**
		 Get the group object

		 @return the group object
		 */
		public function getGroup() {
			if (isset($_POST['groupName'])) {
				global $database;
				$this -> groupId = $database -> getGroupId($_POST['groupName']);
				$this -> group = new \Group($this -> groupId, $database);
			}
			return $this -> group;
		}

		/**
		 Remove a user from the group
		 */
		private function removeUser($userId) {
			$this -> group -> removeUser($userId);
		}

	}

}
?>
