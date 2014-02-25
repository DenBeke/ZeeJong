<?php 
/*
Abstract controller class

Created: February 2014
*/


	abstract class Controller {

				
		/**
		Render the template part of the view
	
		@exception theme file does not exist
		*/
		abstract public function template();
		
		
		/**
		Call GET methode with parameters
		
		@param params
		*/
		public function GET($args) {
		}
		
		
		/**
		Call GET methode with parameters
		
		@param params
		*/
		public function POST($args) {
		}
	
	}





?>