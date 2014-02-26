<?php
/*
Index file for Betting System

Created: February 2014
*/
session_start();


require_once(dirname(__FILE__) . '/core/config.php');
require_once(dirname(__FILE__) . '/core/database.php');	// Require the database file
require_once(dirname(__FILE__) . '/core/classes/User.php');	// We need the user class file
require_once(dirname(__FILE__) . '/core/functions.php');
require_once(dirname(__FILE__) . '/core/register.php');
require_once(dirname(__FILE__) . '/core/gluephp/glue.php');
require_once(dirname(__FILE__) . '/core/controller/login.php');
require_once(dirname(__FILE__) . '/core/controller/Player.php');
require_once(dirname(__FILE__) . '/core/controller/Home.php');
require_once(dirname(__FILE__) . '/core/controller/Register.php');

//Create database
$database = new Database;


$urls = array(
	'/ZeeJong/player' => 'Controller\Player',
	'/ZeeJong/register' => 'Controller\Register',
	'/ZeeJong/' => 'Controller\Home',
	'/ZeeJong/login' => 'Controller\Login'
);


$controller = glue::stick($urls);



//Create register controller
$register = new Register;


//Include the header template
include(dirname(__FILE__) . '/theme/header.php');



$controller->template();


//Include the footer template
include(dirname(__FILE__) . '/theme/footer.php');

?>
