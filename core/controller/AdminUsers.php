<?php
/*
Admin Controller

Created May 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class AdminUsers extends Controller {

		public $page = 'admin-users';

		public $title;



		public function __construct() {
			$this->theme = 'admin-users.php';
			$this->title = 'Admin - Users - ' . Controller::siteName;

		}

	}

}

?>
