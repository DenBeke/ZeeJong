<?php
/*
Player Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');
require_once(dirname(__FILE__) . '/../classes/Player.php');
require_once(dirname(__FILE__) . '/Error.php');


	class Country extends Controller {

		public $country;
		public $title;


		public function __construct() {
			$this->theme = 'country.php';
			$this->title = 'Country - ' . Controller::siteName;
		}


		/**
		Call GET methode with parameters

		@param params
		*/
		public function GET($args) {
			if(!isset($args[1])) {
				throw new \exception('No country id given');
				return;
			}

			global $database;
			$this->country = $database->getCountryById($args[1]);

			$this->title = 'Country - ' . $this->country->getName() . ' - ' . Controller::siteName;
		}


	}

}

?>
