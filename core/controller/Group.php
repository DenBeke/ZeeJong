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
			$this -> setGroup();
			if (isset($_POST['userToRemove'])) {
				$this -> removeUser($_POST['userToRemove']);
			}
			if (isset($_POST['groupToRemove'])) {
				$this -> deleteGroup();
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
			$this -> setGroup();
			return $this -> group;
		}

		/**
		 Remove a user from the group
		 */
		private function removeUser($userId) {
			$this -> group -> removeUser($userId);
		}

		/**
		 Delete the group
		 */
		private function deleteGroup() {
			if (!$this -> mayGroupBeDeleted()) {
				return;
			}
			// Delete the membership of the owner
			$this -> group -> removeUser($_SESSION['userID']);
			// Delete the group itself
			global $database;
			$database -> removeGroup($this -> groupId);
		}

		/**
		 Try to set the group (only possible when groupId was set in POST)
		 */
		public function setGroup() {
			if (isset($_POST['groupName'])) {
				global $database;
				if (!$database -> doesGroupNameExist($_POST['groupName'])) {
					$this -> errorMessage = $this -> errorMessage . "This group does not exist." . "\r\n";
					return False;
				}
				$this -> groupId = $database -> getGroupId($_POST['groupName']);
				$this -> group = new \Group($this -> groupId, $database);
			} else if (isset($_POST['groupToRemove'])) {
				global $database;
				if (!$database -> doesGroupNameExist($_POST['groupToRemove'])) {
					$this -> errorMessage = $this -> errorMessage . "This group does not exist." . "\r\n";
					return False;
				}
				$this -> groupId = $database -> getGroupId($_POST['groupToRemove']);
				$this -> group = new \Group($this -> groupId, $database);
			}
			return True;
		}

		/**
		 Can group be deleted?  The group can only be deleted if only the owner is left as member

		 @return a boolean indicating whether the group may be deleted
		 */
		public function mayGroupBeDeleted() {
			$this -> setGroup();
			return (count($this -> group -> getMembers()) <= 1 && $this -> group -> isUserOwner($_SESSION['userID']));
		}

	}

}
?>
