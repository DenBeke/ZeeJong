<?php
/*
Index file for Betting System

Created: February 2014
*/
session_start();

//Set default time zone
date_default_timezone_set('Europe/Brussels');


require_once(dirname(__FILE__) . '/core/config.php');
require_once(dirname(__FILE__) . '/core/database.php');
require_once(dirname(__FILE__) . '/core/Selector.php');
require_once(dirname(__FILE__) . '/core/classes/User.php');
require_once(dirname(__FILE__) . '/core/functions.php');
require_once(dirname(__FILE__) . '/core/gluephp/glue.php');
require_once(dirname(__FILE__) . '/core/controller/login.php');
require_once(dirname(__FILE__) . '/core/controller/login-alternative.php');
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
require_once(dirname(__FILE__) . '/core/controller/Events.php');
require_once(dirname(__FILE__) . '/core/controller/TopPlayers.php');
require_once(dirname(__FILE__) . '/core/controller/createGroup.php');
require_once(dirname(__FILE__) . '/core/controller/Country.php');
require_once(dirname(__FILE__) . '/core/controller/Group.php');
require_once(dirname(__FILE__) . '/core/controller/InviteUser.php');
require_once(dirname(__FILE__) . '/core/controller/Invites.php');
require_once(dirname(__FILE__) . '/core/controller/Page.php');
require_once(dirname(__FILE__) . '/core/controller/PageEdit.php');

//Create database
$database = new Database;


$urls = array(
	'error' => 'Controller\Error',
	INSTALL_DIR . 'player/(\d+)' => 'Controller\Player',
	INSTALL_DIR . 'register' => 'Controller\Register',
	INSTALL_DIR  => 'Controller\Home',
	INSTALL_DIR . 'login' => 'Controller\Login',
	INSTALL_DIR . 'login-alternative/?(\?.*)?' => 'Controller\LoginAlternative',
	INSTALL_DIR . 'coach/(\d+)' => 'Controller\Coach',
	INSTALL_DIR . 'team/(\d+)' => 'Controller\Team',
	INSTALL_DIR . 'competition/(\d+)' => 'Controller\Competition',
	INSTALL_DIR . 'match/(\d+)' => 'Controller\Match',
	INSTALL_DIR . 'referee/(\d+)' => 'Controller\Referee',
	INSTALL_DIR . 'tournament/(\d+)' => 'Controller\Tournament',
	INSTALL_DIR . 'news' => 'Controller\News',
	INSTALL_DIR . 'config-panel' => 'Controller\UserConfigPanel',
	INSTALL_DIR . 'bets' => 'Controller\Bets',
	INSTALL_DIR . 'place-bet/(\d+)' => 'Controller\placeBet',
	INSTALL_DIR . 'events' => 'Controller\Events',
	INSTALL_DIR . 'player(\?.*)?' => 'Controller\TopPlayers',
	INSTALL_DIR . 'create-group' => 'Controller\CreateGroup',
	INSTALL_DIR . 'country/(\d+)' => 'Controller\Country',
	INSTALL_DIR . 'group/(\S+)' => 'Controller\Group',
	INSTALL_DIR . 'invite-user' => 'Controller\InviteUser',
	INSTALL_DIR . 'invites' => 'Controller\Invites',
	INSTALL_DIR . 'page/(\d+)' => 'Controller\Page',
	INSTALL_DIR . 'page/(\d+)/edit' => 'Controller\PageEdit'
);

$controller = glue::stick($urls);
$navigator = new Controller\Navigator;




//Include the header template
include(dirname(__FILE__) . '/theme/header.php');


//Include the theme part
$controller->template();


//Include the footer template
include(dirname(__FILE__) . '/theme/footer.php');

?>
