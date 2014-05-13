<?php
/*
Admin Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class AdminDashboard extends Controller {

		public $page = 'admindashboard';
		public $coach;
		public $title;


		public function __construct() {
			$this->theme = 'admin-dashboard.php';
			$this->title = 'Admin - Dashboard - ' . Controller::siteName;
		}

	}

}

?>
