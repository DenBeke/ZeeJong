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
require_once(dirname(__FILE__) . '/core/gluephp/glue.php');
require_once(dirname(__FILE__) . '/core/controller/login.php');
require_once(dirname(__FILE__) . '/core/controller/Player.php');
require_once(dirname(__FILE__) . '/core/controller/Home.php');
require_once(dirname(__FILE__) . '/core/controller/Register.php');
require_once(dirname(__FILE__) . '/core/controller/Coach.php');
require_once(dirname(__FILE__) . '/core/controller/Competition.php');
require_once(dirname(__FILE__) . '/core/controller/Tournament.php');
require_once(dirname(__FILE__) . '/core/controller/Match.php');
require_once(dirname(__FILE__) . '/core/controller/Referee.php');
require_once(dirname(__FILE__) . '/core/controller/Error.php');

//Create database
$database = new Database;


$urls = array(
	'error' => 'Controller\Error',
	'/ZeeJong/error' => 'Controller\Error',
	'/ZeeJong/player' => 'Controller\Player',
	'/ZeeJong/register' => 'Controller\Register',
	'/ZeeJong/' => 'Controller\Home',
	'/ZeeJong/login' => 'Controller\Login',
	'/ZeeJong/coach' => 'Controller\Coach',
	'/ZeeJong/competition' => 'Controller\Competition',
	'/ZeeJong/match' => 'Controller\Match',
	'/ZeeJong/referee' => 'Controller\Referee',
	'/ZeeJong/tournament' => 'Controller\Tournament'
);


$controller = glue::stick($urls);




//Include the header template
include(dirname(__FILE__) . '/theme/header.php');



$controller->template();


//Include the footer template
include(dirname(__FILE__) . '/theme/footer.php');

?>
