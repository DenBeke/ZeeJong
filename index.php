<?php
/*
Index file for Betting System

Created: February 2014
*/

require_once(dirname(__FILE__) . '/core/config.php');
require_once(dirname(__FILE__) . '/core/functions.php');


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
else {
	include(dirname(__FILE__) . '/theme/error.php');
}


//Include the footer template
include(dirname(__FILE__) . '/theme/footer.php');

?>
