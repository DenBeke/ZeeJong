<?php
/*
File to register new users
*/
require_once(dirname(__FILE__) . '/config.php');	// Require config file containing configuration of the database
require_once(dirname(__FILE__) . '/database.php');	// Require the database file
require_once(dirname(__FILE__) . '/functions.php');

/**
Generate a salt
*/
function generateSalt() {
	return uniqid(rand(0, 1000000));
}



/**
Register a user
*/
function registerUser($username, $password, $emailAddress) {
	// TODO	Make sure username is available!
	$db = new Database;
	$salt = generateSalt();
	$hashedPassword = hashPassword($password,$salt);
	$id = $db->registerUser($username, $salt,$hashedPassword, $emailAddress);
	header('Location: ../registerSuccess');
}

if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email'])) {
	exit();
}

$username=$_POST['username'];
$password=$_POST['password']; 

$emailAddress=$_POST['email']; 
registerUser($username,$password,$emailAddress);

?>
