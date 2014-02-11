<?php
/*
Script for fetching and parsing html pages


Created: February 2014
*/


require_once( dirname(__FILE__) . '/simple_html_dom.php' );


function parse($url) {
	
	$html = file_get_html($url);
	
	
	foreach($html->find('.match') as $element) {
		echo '<li>';
		echo $element->find('.team-a a', 0)->plaintext;
		echo $element->find('.score', 0)->plaintext;
		//Recursive call for parsing the match data
		echo $element->find('.team-b a', 0)->plaintext;
		echo '</li>';
	}
	
}


?>