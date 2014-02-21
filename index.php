<?php
/*
Index file for Betting System

Created: February 2014
*/
session_start();

require_once(dirname(__FILE__) . '/core/database.php');	// Require the database file
require_once(dirname(__FILE__) . '/core/classes/User.php');	// We need the user class file
require_once(dirname(__FILE__) . '/core/config.php');
require_once(dirname(__FILE__) . '/core/functions.php');

$d = new Database;


//Create database
$database = new Database;


//Parse the page
$page = 'home';

if(isset($_GET['page'])) {
	$page = htmlspecialchars($_GET['page']);
}


try {

	$object = getObject($page);
	
}

catch(exception $e) {
	
	$page = 'error';
	echo $e->getMessage();
	
}


define('PAGE', $page);



//Include the header template
include(dirname(__FILE__) . '/theme/header.php');



//Include the correct page template
if(PAGE == 'home') {
	include(dirname(__FILE__) . '/theme/home.php');
}
elseif(PAGE == 'competition') {
	include(dirname(__FILE__) . '/theme/competition.php');
}
elseif(PAGE == 'tournament') {
	include(dirname(__FILE__) . '/theme/competition.php');
}
elseif(PAGE == 'match') {
	include(dirname(__FILE__) . '/theme/match.php');
}
elseif(PAGE == 'player') {
	include(dirname(__FILE__) . '/theme/player.php');
}
elseif(PAGE == 'coach') {
	include(dirname(__FILE__) . '/theme/coach.php');
}
elseif(PAGE == 'referee') {
	include(dirname(__FILE__) . '/theme/referee.php');
}
elseif(PAGE== 'register') {
	include(dirname(__FILE__) . '/theme/register.php');
}
elseif(PAGE== 'registerSuccess') {
	include(dirname(__FILE__) . '/theme/registrationSuccess.php');
}
else {
	include(dirname(__FILE__) . '/theme/error.php');
}


//Include the footer template
include(dirname(__FILE__) . '/theme/footer.php');

?>
