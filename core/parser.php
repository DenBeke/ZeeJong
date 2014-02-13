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

		break;

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
	$rawGoals = $html->find('.block_match_goals', 0);
	$goals = array();
	foreach ($rawGoals->find('.player') as $player) {
		if(sizeof($player->find('.minute', 0)) > 0) {
		    $playerName = $player->find('a', 0)->plaintext;
		    $time = $player->find('.minute', 0)->plaintext;
			$goals[intval($time)] = $playerName;
		}
	}

	foreach ($goals as $a => $b) {
		echo "--- Goal: $b ($a')<br>";
	}
	
	
	//Find the referee
	$referee = $html->find('.referee', 0)->plaintext;
	echo "--- Referee: $referee<br>";
	
	//Find the date
	$date = $html->find('.middle .details dd', 1)->plaintext;
	echo "--- Date: $date<br>";
	
	//Find the final score
	$score = $html->find('#subheading .bidi', 0)->plaintext;
	$score = explode(' - ', $score);
	
	$scoreA = intval($score[0]);
	$scoreB = intval($score[1]);
		
	echo "--- Score: $scoreA vs $scoreB<br>";
	
	
	//Find the place where the match took place
	
	
	
	$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
	
}


?>
