<?php
/*
Script for fetching and parsing html pages


Created: February 2014
*/


require_once( dirname(__FILE__) . '/simple_html_dom.php' );


function parse($url) {
	
	$html = file_get_html($url);
	
	//Find all matches
	foreach($html->find('.match') as $element) {
		
		//Find general data for match
		$teamA = $element->find('.team-a a', 0)->plaintext;
		$teamB = $element->find('.team-b a', 0)->plaintext;
		$score = $element->find('.score', 0)->plaintext;
		$scoreUrl = $element->find('.score a', 0)->href;
		
		echo '<li>';
		echo $teamA;
		echo $score;
		echo $teamB;
		echo '<br>';
		
		//Recursive call for parsing the detailed match data
		parseMatch('http://int.soccerway.com' . $scoreUrl);
	
		echo '</li>';

		//Still a bug at the end when parsing this page:
		// http://int.soccerway.com/international/world/world-cup/2010-south-africa/s4770/final-stages/

	}
	
}


function parseMatch($url) {
	
	
	$html = file_get_html($url);
	
	//Find the two blocks of players (for each team)
	foreach ($html->find('.block_match_lineups > div') as $block) {
		//Find all players of a team
		foreach ($block->find('.player a') as $player) {
			$playerName = $player->plaintext;
			echo "- $playerName <br>";	
		}
	}
	
	
	//Find the goals
	$goals = $html->find('.block_match_goals', 0);
	foreach ($goals->find('.player') as $player) {
		$playerName = $player->find('a', 0)->plaintext;
		$time = $player->find('.minute', 0)->plaintext;
		echo "--- Goal: $playerName ($time)<br>";
	}
	
	
	//Find the referee
	
	
	//Find the date
	
	
	//Find the final score
	
	
	//Find the place where the match took place
	
	
	$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
	
}


?>