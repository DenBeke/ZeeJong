<?php
/*
Admin Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Admin extends Controller {

		public $page = 'admin';
		public $coach;
		public $title;


		public function __construct() {
			$this->theme = 'admin.php';
			$this->title = 'Admin - ' . Controller::siteName;
		}

	}

}

?>
