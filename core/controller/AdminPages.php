<?php
/*
Admin Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class AdminPages extends Controller {

		public $page = 'admin-pages';
		public $coach;
		public $title;
		public $pages;


		public function __construct() {
			$this->theme = 'admin-pages.php';
			$this->title = 'Admin - Pages - ' . Controller::siteName;
			
			$this->createPage();
			$this->addAnalytics();
			
			
			global $database;
			$this->pages = $database->getAllPages();
		}
		
		
		private function createPage()
		{
		    if ((isset($_POST['title'])) && (isset($_POST['content'])) && ($_POST['title'] != '') && ($_POST['content'] != '')) {
		    
		        global $database;
		        $database->addPage($_POST['title'], $_POST['content']);
		    }
		}
		
		
		private function addAnalytics() {
			if( isset($_POST['analytics'])) {
				\saveAnalytics($_POST['analytics']);
			}
		}
		
	}

}

?>
