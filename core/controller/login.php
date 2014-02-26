<?php
/*
Login file allowing users to log in
*/

namespace Controller {

	require_once(dirname(__FILE__) . '/../config.php');	// Require config file containing configuration of the database
	require_once(dirname(__FILE__) . '/../database.php');	// Require the database file
	require_once(dirname(__FILE__) . '/../classes/User.php');	// We need the user class file
	require_once(dirname(__FILE__) . '/../functions.php');
	require_once(dirname(__FILE__) . '/Controller.php');
	
	
	class Login extends Controller {
	
	
		public $page = 'login';
		public $loggedIn;
		public $loginMessage;
		public $user;
		private $template = 'login.php';
		
		
		
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
	
	
	
		public function __construct() {
		
			$this->checkLogin();
		
		}
	
	
		/**
		Try to login with the given username and password
		
		@param username
		@param password
		
		@return true (login succeded) / false (wrong login details)
		*/
		private function login($username, $password) {
			$d = new \Database;
			if($d->doesUsernameExist($username)){
				$user = $d->getUser($username);
				if(hashPassword($password,$user->getSalt()) == $user->getHash()){
					session_regenerate_id();
					$_SESSION['userID'] = $user->getID();
					session_write_close();
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		
		
		
		

		public function GET($args) {
			$this->data = $args;
		}
		
		
		
		public function POST($args) {
			$this->data = array_merge($this->data, $args);
		}
		
		
	
		private function checkLogin() {
		
			global $database;
		
			//Check if login page
		
					
			//Check for active session
			if( isset($_SESSION['userID']) and $database->doesUserExist($_SESSION['userID'])) {
				$this->loginMessage = 'You are already logged in';
				$this->loggedIn = true;
				$this->user = new \User($_SESSION['userID']);
			}
			elseif(!isset($_POST['username']) or !isset($_POST['password']) or $_POST['username'] == '' or $_POST['password'] == '') {
				$this->loginMessage = 'Please provide username and password';
				$this->loggedIn = false;
			}
			else {
			
				$username = htmlspecialchars($_POST['username']);
				$password = htmlspecialchars($_POST['password']); 
				
				if($this->login($username,$password)) {
					$this->loginMessage = "Hi, $username!";
					$this->loggedIn = true;
					$this->user = $database->getUser($username);
				}
				else {
					$this->loginMessage = 'Wrong username or password';
					$this->loggedIn = false;
				}
				
			}
					
				
		}

		
			
		
		
		
	
	
	} //end class Login
	


} //end namespace Controller
	
?>