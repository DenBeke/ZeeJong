<?php
/*
Player Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');
require_once(dirname(__FILE__) . '/../classes/Player.php');
require_once(dirname(__FILE__) . '/Error.php');


	class Player extends Controller {

		public $player;

		public function __construct() {
			$this->theme = 'player.php';
		}
		
		
		/**
		Call GET methode with parameters
		
		@param params
		*/
		public function GET($args) {
			global $database;
			$this->player = $database->getPlayerById($args[1]);
		}
	
	
	}

}

?>
