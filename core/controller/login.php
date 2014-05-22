<?php
/*
Login file allowing users to log in
*/

namespace Controller {

    require_once(dirname(__FILE__) . '/../config.php'); // Require config file containing configuration of the database
    require_once(dirname(__FILE__) . '/../database.php');   // Require the database file
    require_once(dirname(__FILE__) . '/../classes/User.php');   // We need the user class file
    require_once(dirname(__FILE__) . '/../functions.php');
    require_once(dirname(__FILE__) . '/Controller.php');


    class Login extends Controller {


        public $page = 'login';
        public $loggedIn;
        public $loginMessage;
        public $user;
        public $title;

        public $openidId;
        public $openidName;
        public $openidEmail;


        public function __construct() {
            $this->theme = 'login.php';
            $this->title = 'Login - ' . Controller::siteName;
            $this->loggedIn = false;

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


        protected function alternativeLogin() {

            global $database;

            //Check for active session
            if( isset($_SESSION['userID']) and $database->doesUserExist($_SESSION['userID'])) {
                $this->loginMessage = 'You are already logged in';
                $this->loggedIn = true;
                $this->user = new \User($_SESSION['userID']);
            }
            elseif(!isset($this->openidId) or !isset($this->openidName) or $this->openidId == '' or $this->openidName == '') {
                $this->loginMessage = 'Could not access your first name.';
                $this->loggedIn = false;
            }
            else {

                if (!$database->doesAlternativeUserExist($this->openidId)) {

                    //Make sure there isn't already an account with this name
                    if ($database->doesUsernameExist($this->openidName)) {
                        $this->loginMessage = 'A user with your name already exists.';
                        $this->loggedIn = false;
                        return;
                    }

                    $salt = uniqid(rand(0, 1000000));
                    $hashedPassword = hashPassword($this->openidName, $salt);
                    $database->registerAlternativeUser($this->openidId, $this->openidName, $salt, $hashedPassword, $this->openidEmail);
                }

                $user = $database->getAlternativeUser($this->openidId);

                if(hashPassword($this->openidName, $user->getSalt()) == $user->getHash()){
                    session_regenerate_id();
                    $_SESSION['userID'] = $user->getID();
                    session_write_close();

                    $this->loginMessage = "Hi, $this->openidName!";
                    $this->loggedIn = true;
                }
                else {
                    $this->loginMessage = 'Failed to login.';
                    $this->loggedIn = false;
                }
            }
        }



        public function GET($args) {
            $this->data = $args;

            $openid = new \LightOpenID(SITE_URL);

            if(isset($_GET['fblogin'])) {

                $this->openidId = $_GET['id'];
                $this->openidName = $_GET['first'];
                $this->openidEmail = $_GET['email'];

                if ($this->openidEmail == 'undefined') {
                    $this->openidEmail = '';
                }

                $this->alternativeLogin();
            }
            else {
                if ($openid->mode) {
                    if ($openid->mode == 'cancel') {
                        throw new Exception("User has canceled authentication!");
                    } elseif($openid->validate()) {
                        $data = $openid->getAttributes();
                        $this->openidEmail = $data['contact/email'];

                        if (array_key_exists('namePerson/first', $data)) {
                            $this->openidName = $data['namePerson/first'];
                        }
                        else {
                            $this->openidName = $this->openidEmail;
                        }

                        $this->openidId = $openid->identity;

                        $this->alternativeLogin();
                    }
                }
                else {
                    if(isset($_GET['oid'])) {
                        $oid = $_GET['oid'];

                        if ($oid != '') {
                            $openid->identity = $oid;

                            $openid->required = array(
                              'namePerson/first',
                              'contact/email',
                            );

                            $openid->returnUrl = SITE_URL . 'login/';
                            Header('Location:' . $openid->authUrl());
                        }
                    }
                }
            }

            if($this->loggedIn) {
                header("refresh:2;url=" . SITE_URL);
            }
        }



        public function POST($args) {
            $this->data = array_merge($this->data, $args);
        }



        private function checkLogin() {

            global $database;

            //Check for active session
            if( isset($_SESSION['userID']) and $database->doesUserExist($_SESSION['userID'])) {
                $this->loginMessage = 'You are already logged in';
                $this->loggedIn = true;
                $this->user = new \User($_SESSION['userID']);
            }
            elseif(isset($_POST['username']) and isset($_POST['password'])) {

                if ($_POST['username'] == '' or $_POST['password'] == '') {
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
        }


    } //end class Login



} //end namespace Controller

?>
