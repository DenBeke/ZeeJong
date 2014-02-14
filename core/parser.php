<?php
/*
Script for fetching and parsing html pages


Created: February 2014
*/


require_once( dirname(__FILE__) . '/simple_html_dom.php' );




function parse() {
	
	
	$competitions = array(

		'wk' => array(
			'name' => 'World Cup',
			'url' => 'http://int.soccerway.com/international/world/world-cup/c72/archive/?ICID=PL_3N_06'
		),

		'eu' => array(
			'name' => 'European Championship',
			'url' => 'http://int.soccerway.com/international/europe/european-championships/c25/archive/?ICID=PL_3N_05'
		),

		'olympics' => array(
			'name' => 'Olympics',
			'url' => 'http://int.soccerway.com/international/world/olympics/c221/archive/?ICID=PL_3N_04'
		)

	);
	
	
	
	//Loop through competition and parse the competitions
	foreach ($competitions as $competition) {
		echo '<em>Parsing: ' . $competition['name'] . '</em><br>';
		parseCompetition($competition['url']);
	}
	
	
}




function parseCompetition($url) {

	$html = file_get_html($url);
	
	//Find all tournaments
	foreach($html->find('.season a') as $element) {
	    $name = $element->plaintext;
	    echo "<h2>$name</h2>";

	    $tournamentUrl = $element->href;
	    parseTournament('http://int.soccerway.com' . $tournamentUrl);
	}
	
	$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
}



function parseTournament($url) {
	
	$html = file_get_html($url);
	
	//Find all matches
	foreach($html->find('.match') as $element) {
		
		//Find general data for match
		$teamA = $element->find('.team-a a', 0)->plaintext;
		$teamB = $element->find('.team-b a', 0)->plaintext;
		$score = $element->find('.score', 0)->plaintext;
		$scoreUrl = $element->find('.score a', 0)->href;
		
		echo '<li>';
		echo '<h3>';
		echo $teamA;
		echo $score;
		echo $teamB;
		echo '</h3>';
		
		//Recursive call for parsing the detailed match data
		parseMatch('http://int.soccerway.com' . $scoreUrl);
	
		echo '</li>';

		//Still a bug at the end when parsing this page:
		// http://int.soccerway.com/international/world/world-cup/2010-south-africa/s4770/final-stages/

	}
	
	$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
	
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
	if(gettype($rawGoals) != 'NULL') {
	
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
