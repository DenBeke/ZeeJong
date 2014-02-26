<?php
/*
Tournament Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class Tournament extends Controller {
	
	
		private $template = 'tournament.php';
		public $page = 'tournament';
	
	
		/**
		Render the template part of the view
		
		@exception theme file does not exist
		*/
		public function template() {
			
			if(is_array($this->data)) {
				extract($this->data);
			}
			
			if(file_exists($this->themeDir . '/' . $this->template)) {
				include($this->themeDir . '/' . $this->template);
			}
			
		
		}
		
		
		/**
		Call GET methode with parameters
		
		@param params
		*/
		public function GET($args) {
		}
	
	
	}

}

?>