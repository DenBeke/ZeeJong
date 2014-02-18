<?php
/*
Index file for Betting System

Created: February 2014
*/

require_once(dirname(__FILE__) . '/core/config.php');


//Parse the page
$page = 'home';

if(isset($_GET['page'])) {
	$page = htmlspecialchars($_GET['page']);
}

define('PAGE', $page);



//Include the header template
include(dirname(__FILE__) . '/theme/header.php');


echo '<pre>';
var_dump($_SERVER);
echo '</pre>';


//Include the correct page template
if(PAGE == 'home') {
	include(dirname(__FILE__) . '/theme/home.php');
}
else {
	include(dirname(__FILE__) . '/theme/error.php');
}


//Include the footer template
include(dirname(__FILE__) . '/theme/footer.php');

?>
