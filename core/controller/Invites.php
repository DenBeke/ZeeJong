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
	// We need the group membership class file

	class Invites extends Controller {

		public $page = 'invites';
		public $title;
		private $successMessage;
		private $invites;

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

			if (!isset($_POST['inviteId'])) {
				return;
			}
			$this->acceptInvite();
		}
		
		/**
		 * Accept an invite
		 */
		 private function acceptInvite(){
		 	global $database;
			$database->acceptInvite($_POST['inviteId']);
			$this -> invites = $database -> getInvites($_SESSION['userID']);
		 }
		
		/**
		 * Get the invites
		 * @return an array with invite ID's for the user
		 */
		public function getInvites(){
			return $this->invites;
		}

	}

}
