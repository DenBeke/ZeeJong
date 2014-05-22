<?php
/*
 Admin Bet Updater Controller

 Created May 2014
 */

namespace Controller {

	require_once (dirname(__FILE__) . '/Controller.php');
	require_once (dirname(__FILE__) . '/../betHandler.php');

	class AdminUpdateBets extends Controller {
		public $page = 'admin-update-bets';
		public $title;
		private $betHandler;
		/**
		 * Constructor
		 */
		public function __construct() {
			$this -> theme = 'admin-update-bets.php';
			$this -> title = 'Admin - Update - Bets - ' . Controller::siteName;
			if (!isAdmin()) {
				return;
			}
			$this -> betHandler = new \BetHandler;

		}
		
		/**
		 * Update the bets
		 */
		public function update() {
			$this -> betHandler -> genBetsToProcess();
			$this -> betHandler -> processBets();
		}

		/**
		 * Get the amount of bets processed
		 */
		public function getBetsProcessed() {
			return $this -> betHandler -> getBetsProcessed();
		}


		/**
		 * Get the amount of money distributed
		 */
		public function getMoneyDistributed() {
			return $this -> betHandler -> getMoneyDistributed();
		}

		/**
		 * Get the total amount of parameters bet on
		 */
		public function getParametersBetOn() {
			return $this -> betHandler -> getParametersBetOn();
		}

	}

}
