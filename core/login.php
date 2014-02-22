<?php
/*
Login file allowing users to log in
*/
require_once(dirname(__FILE__) . '/config.php');	// Require config file containing configuration of the database
require_once(dirname(__FILE__) . '/database.php');	// Require the database file
require_once(dirname(__FILE__) . '/classes/User.php');	// We need the user class file
require_once(dirname(__FILE__) . '/functions.php');



/**
Try to login with the given username and password

@param username
@param password

@return true (login succeded) / false (wrong login details)
*/
function login($username, $password) {
	$d = new Database;
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


?>