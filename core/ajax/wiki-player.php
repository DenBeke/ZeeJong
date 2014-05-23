<?php
/*
Returns JSON objects for the 'News' page.

Created February 2014
*/

require_once(dirname(__FILE__) . '/../controller/Player.php');
require_once(dirname(__FILE__) . '/../database.php');

//Create database
$database = new Database;



$controller = new \Controller\Player;



if(isset($_GET['player'])) {

	if(intval($_GET['player'])) {
		$controller->GET([1 => $_GET['player']]);
		$output['wiki'] = $controller->getWiki();
		
		if($output['wiki'] == false) {
			$output['error'] = 'No wiki information found';
		}
		
	}
	else {

		$output['error'] = 'Player does not exist';

	}


}
else {
	$output['error'] = 'No player id given';
}



if(isset($_GET['debug'])) {
	echo '<pre>' . json_encode($output, JSON_PRETTY_PRINT) . '</pre>';
}
else {
	echo json_encode($output, JSON_PRETTY_PRINT);
}


?>

