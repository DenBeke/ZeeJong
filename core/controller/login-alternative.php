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


	class LoginAlternative extends Controller {


		public $page = 'login-alternative';
		public $loggedIn;
		public $loginMessage;
		public $user;
		public $title;
		
		public $id;
		public $name;
		public $email;


		public function __construct() {
			$this->theme = 'login-alternative.php';
			$this->title = 'Login - ' . Controller::siteName;
		}


		public function GET($args) {
			$this->data = $args;
		}



		public function POST($args) {
			$this->data = array_merge($this->data, $args);
		}

        /**
		 * Generate a salt
		 */
		private function generateSalt() {
			return uniqid(rand(0, 1000000));
		}

		protected function login() {

			global $database;

			//Check for active session
			if( isset($_SESSION['userID']) and $database->doesUserExist($_SESSION['userID'])) {
				$this->loginMessage = 'You are already logged in';
				$this->loggedIn = true;
				$this->user = new \User($_SESSION['userID']);
			}
			elseif(!isset($this->id) or !isset($this->name) or $this->id == '' or $this->name == '') {
				$this->loginMessage = 'Could not access your first name.';
				$this->loggedIn = false;
			}
			else {
			
			    if (!$database->doesAlternativeUserExist($this->id)) {
			        $salt = $this->generateSalt();
			        $hashedPassword = hashPassword($this->name, $salt);
			        $database->registerAlternativeUser($this->id, $this->name, $salt, $hashedPassword, $this->email);
			    }
			    
			    $user = $database->getAlternativeUser($this->id);
			    
			    if(hashPassword($this->name, $user->getSalt()) == $user->getHash()){
					session_regenerate_id();
					$_SESSION['userID'] = $user->getID();
					session_write_close();
					
					$this->loginMessage = "Hi, $this->name!";
			        $this->loggedIn = true;
				}
			    else {
					$this->loginMessage = 'Failed to login.';
					$this->loggedIn = false;
				}
			}


		}








	} //end class Login



} //end namespace Controller

?>
