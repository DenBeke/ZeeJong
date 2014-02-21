<?php
/*
Login file allowing users to log in
*/
require_once(dirname(__FILE__) . '/config.php');	// Require config file containing configuration of the database
require_once(dirname(__FILE__) . '/database.php');	// Require the database file
require_once(dirname(__FILE__) . '/classes/User.php');	// We need the user class file
require_once(dirname(__FILE__) . '/functions.php');




function login($username, $password) {
	$d = new Database;
	if($d->doesUsernameExist($username)){
		$user = $d->getUser($username);
		if(hashPassword($password,$user->getSalt()) == $user->getHash()){
			session_regenerate_id();
			$_SESSION['userID'] = $user->getID();
			session_write_close();
			header('Location: ../');
		}
		else{
			echo "Wrong password";
		}
	}
	else{
		echo "User does not exist";
	}
}


try {


	$username = $_POST['username'];
	$password = $_POST['password']; 
	
	login($username,$password);

}

catch (exception $exception) {
	echo "Database Error";
}

?>

