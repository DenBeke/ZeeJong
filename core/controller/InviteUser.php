<?php
/*
 File to invite a user to a group
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

	class InviteUser extends Controller {

		public $page = 'invite-user';
		public $title;

		private $groups;
		private $errorMessage;
		private $successMessage;

		/**
		 * Constructor
		 */
		public function __construct() {
			$this -> theme = 'inviteUser.php';
			$this -> title = 'Invite a User - ' . Controller::siteName;
			if (!isset($_SESSION['userID'])) {
				return;
			}

			global $database;
			$this->groups = $database -> getGroupsWithOwner($_SESSION['userID']);
			
			if (!isset($_POST['userName'])||!isset($_POST['groupName'])) {
				return;
			}
			if(!$database->doesUserNameExist($_POST['userName'])){
				$this->errorMessage = $this->errorMessage."User does not exist." ."\r\n";
				return;
			}
			$this -> inviteUser();
		}

		private function inviteUser() {
			global $database;
			$groupId = $database->getGroupId($_POST['groupName']);
			$userId = $database->getUser($_POST['userName'])->getId();
			
			if($database->doesInviteExist($userId,$groupId)){
				$this->errorMessage = $this->errorMessage."An invite for that group was already sent to the same user or the user is already a member of that group." . "\r\n";
				return;
			}
			
			$database->addGroupMembership($userId,$groupId);
			$this -> successMessage = $this -> successMessage . "Successfully sent invite." . "\r\n";
		}

		public function getGroups() {
			return $this -> groups;
		}
		
		public function getSuccessMessage(){
			return $this->successMessage;
		}
		public function getErrorMessage(){
			return $this->errorMessage;
		}

	}

}
?>