<?php
/*
 Invites controller

 Created April 2014
 */

namespace Controller {

	require_once (dirname(__FILE__) . '/../config.php');
	// Require config file containing configuration of the database
	require_once (dirname(__FILE__) . '/../database.php');
	// Require the database file
	require_once (dirname(__FILE__) . '/../functions.php');
	require_once (dirname(__FILE__) . '/Controller.php');
	require_once (dirname(__FILE__) . '/../classes/GroupMembership.php');
	require_once (dirname(__FILE__) . '/../classes/Group.php');
	// We need the group membership class file

	class Invites extends Controller {

		public $page = 'invites';
		public $title;
		private $successMessage;
		private $invites;
		private $sentInvites;

		/**
		 * Constructor
		 */
		public function __construct() {
			$this -> theme = 'invites.php';
			$this -> title = 'Your invites - ' . Controller::siteName;
			if (!isset($_SESSION['userID'])) {
				return;
			}

			global $database;
			$this -> invites = $database -> getInvites($_SESSION['userID']);
			$this -> sentInvites = $database -> getInvitesSent($_SESSION['userID']);
			if (!isset($_POST['inviteId'])) {
				return;
			}
			if (isset($_POST['accept'])) {
				$this -> acceptInvite();
			}
			if(isset($_POST['withdraw'])){
				$this -> withdraw();
			}
		}

		/**
		 * Accept an invite
		 */
		private function acceptInvite() {
			global $database;
			$database -> acceptInvite($_POST['inviteId']);
			$this -> invites = $database -> getInvites($_SESSION['userID']);
		}

		/**
		 * Get the invites
		 * @return an array with invite ID's for the user
		 */
		public function getInvites() {
			return $this -> invites;
		}

		/**
		 * Get the sent invites
		 * @return an array with invite ID's
		 */
		public function getSentInvites() {
			return $this -> sentInvites;
		}
		
		/**
		 * Withdraw an invite
		 */
		 private function withdraw(){
		 	// test if user is group owner (security)
		 	global $database;
			$group = new \Group($database->getGroupIdFromMembership($_POST['inviteId']),$database);
			if(!$group->isUserOwner($_SESSION['userID'])){
				return;
			}
			$database->withdrawInvite($_POST['inviteId']);
			$this -> sentInvites = $database -> getInvitesSent($_SESSION['userID']);
		 }

	}

}
