<?php
/*
Player Controller

Created February 2014
*/


require_once(dirname(__FILE__) . '/Controller.php');
require_once(dirname(__FILE__) . '/../classes/Player.php');




	class PlayerController extends Controller {
	
	
		private $template = 'Player.php';
	
	
		/**
		Render the template part of the view
		
		@exception theme file does not exist
		*/
		public function template() {
		
			echo $this->template;
		
		}
		
		
		/**
		Call GET methode with parameters
		
		@param params
		*/
		public function GET($args) {
			
		}
	
	
	}



?>