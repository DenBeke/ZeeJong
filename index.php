<?php
/*
Index file for Betting System

Created: February 2014
*/
session_start();

//Set default time zone
date_default_timezone_set('Europe/Brussels');


require_once(dirname(__FILE__) . '/core/config.php');
require_once(dirname(__FILE__) . '/core/database.php');	// Require the database file
require_once(dirname(__FILE__) . '/core/Selector.php');
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
require_once(dirname(__FILE__) . '/core/controller/News.php');
require_once(dirname(__FILE__) . '/core/controller/UserConfigPanel.php');
require_once(dirname(__FILE__) . '/core/controller/Navigator.php');
require_once(dirname(__FILE__) . '/core/controller/Team.php');
require_once(dirname(__FILE__) . '/core/controller/Bets.php');
require_once(dirname(__FILE__) . '/core/controller/placeBet.php');

//Create database
$database = new Database;


$urls = array(
	'error' => 'Controller\Error',
	INSTALL_DIR . 'player/(\d+)' => 'Controller\Player',
	INSTALL_DIR . 'register' => 'Controller\Register',
	INSTALL_DIR  => 'Controller\Home',
	INSTALL_DIR . 'login' => 'Controller\Login',
	INSTALL_DIR . 'coach/(\d+)' => 'Controller\Coach',
	INSTALL_DIR . 'team/(\d+)' => 'Controller\Team',
	INSTALL_DIR . 'competition/(\d+)' => 'Controller\Competition',
	INSTALL_DIR . 'match/(\d+)' => 'Controller\Match',
	INSTALL_DIR . 'referee/(\d+)' => 'Controller\Referee',
	INSTALL_DIR . 'tournament/(\d+)' => 'Controller\Tournament',
	INSTALL_DIR . 'news' => 'Controller\News',
	INSTALL_DIR . 'configPanel' => 'Controller\UserConfigPanel',
	INSTALL_DIR . 'bets' => 'Controller\Bets',
	INSTALL_DIR . 'placeBet/(\d+)' => 'Controller\placeBet',
);


$controller = glue::stick($urls);
$navigator = new Controller\Navigator;




//Include the header template
include(dirname(__FILE__) . '/theme/header.php');



$controller->template();


//Include the footer template
include(dirname(__FILE__) . '/theme/footer.php');

?>
