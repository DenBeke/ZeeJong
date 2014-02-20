<?php
/*
Script for fetching and parsing html pages


Created: February 2014
*/


require_once( dirname(__FILE__) . '/simple_html_dom.php' );
require_once( dirname(__FILE__) . '/database.php' );
require_once( dirname(__FILE__) . '/classes/Card.php' );


/**
@brief Class for parsing the archives.
*/
class Parser {

	private $competition;
	private $tournament;

	private $database;

	private $teams;

	// Amount of seconds to store cached files.
	// 0 to always use cache
	// -1 to never use cache
	private $ttl = 0;


	/**
	@brief Constructor of the parser object.
	*/
	public function __construct() {
		$this->database = new Database();
	}


	/**
	Parse the archive and store the data.
	*/
	public function parse() {

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

			$this->competition = $competition['name'];

			echo '<em>Parsing: ' . $competition['name'] . '</em><br>';
			$this->parseCompetition($competition['url']);
		}

		//Save the team urls
		$url_list = implode("\n", array_values($this->teams));
		if (file_put_contents('cache/teams_url_list.cache', $url_list) == false) {
			throw new Exception('Failed to create file cache/teams_url_list.cache');
		}
	}


	/**
	Find out which players are currently playing for which team.

	This function will make use of a list of teams that was created by the parse function.
	*/
	public function parsePlayersInTeams() {

	    //Load the list of urls
	    $file_contents = file_get_contents('cache/teams_url_list.cache');
	    if ($file_contents == FALSE) {
	        throw new Exception('Failed to open cache/teams_url_list.cache');
	    }

	    //Loop over the urls and find the players
	    $url_list = explode("\n", $file_contents);
	    foreach ($url_list as $url) {

	        echo "url: $url<br>";
	        $html = $this->loadPage($url);

	        $countryId = $this->findTeamCountry($url);
	        $teamName = $html->find('#subheading h1', 0)->plaintext;
	        $teamId = $this->database->addTeam($teamName, $countryId);

	        $rows = $html->find('.squad-container tr');
	        foreach ($rows as $row) {

	            $player = $row->find('td a', 1);
	            if (is_object($player)) {
	                echo $player->plaintext . '<br>';
	                $playerId = $this->parsePlayer('http://int.soccerway.com' . $player->href);
	                $this->database->addPlayerToTeam($playerId, $teamId);
	            }

	            $player = $row->find('td a', 3);
	            if (is_object($player)) {
	                $playerId = $this->parsePlayer('http://int.soccerway.com' . $player->href);
	                $this->database->addPlayerToTeam($playerId, $teamId);
	            }
	        }

	        $html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
	    }
    }



	/**
	Load a page, but take the one from the cache when already loaded.

	@param url of the page

	@return DOM object
	*/
	private function loadPage($url) {

		$filename = 'cache/' . md5($url) . '.cache';

		//Try to use the cache
		if ($this->ttl >= 0 && file_exists($filename)) {

			if ($this->ttl == 0 || time() - filemtime($filename) <= $this->ttl) {
				return file_get_html($filename);
			}
		}

		//Download the page
		$try = 0;
		$page = FALSE;
		while ($page == FALSE && $try < 3) {
		    $page = file_get_contents($url);
		    $try += 1;

		    if ($page == FALSE) {
		        usleep(200000);
		    }
		}

		if ($page == FALSE) {
		    throw new Exception('Failed to load ' . $url);
		}

		if (file_put_contents($filename, $page) == false) {
			throw new Exception('Failed to create file ' . $filename);
		}

		return str_get_html($page);
	}


	/**
	Parse the competitions in the archive and store the data.

	@param url of the competition
	*/
	private function parseCompetition($url) {

		$html = $this->loadPage($url);

		//Find all tournaments
		foreach($html->find('.season a') as $element) {

			$tournamentName = $element->plaintext;
			$tournamentUrl = $element->href;

			$this->tournament = $tournamentName;

			echo "<h2>$tournamentName</h2>";

			$this->parseTournament('http://int.soccerway.com' . $tournamentUrl);

		}

		$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
	}


	/**
	Parse the tournaments in the archive and store the data.

	@param url of the tournament
	*/
	private function parseTournament($url) {

		$html = $this->loadPage($url);

		//Find all matches
		foreach($html->find('.match') as $element) {

			$scoreUrl = $element->find('.score a', 0)->href;

			$this->parseMatch('http://int.soccerway.com' . $scoreUrl);
		}

		$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)

	}


	/**
	Parse the match in the archive and store the data.

	@param url of the match
	*/
	private function parseMatch($url) {

		$html = $this->loadPage($url);

		//Add the competition and tournament to the database
		$competitionId = $this->database->addCompetition($this->competition);
		$tournamentId = $this->database->addTournament($this->tournament, $competitionId);

		//Find the referee
		if(is_object($html->find('.referee', 0))) {
			$refereeId = $this->parseReferee('http://int.soccerway.com' . $html->find('.referee', 0)->href);
		}
		else {
			$refereeId = NULL;
		}

		//Find the final score
		$score = $html->find('#subheading .bidi', 0)->plaintext;
		$score = explode(' - ', $score);
		$scoreA = intval($score[0]);
		$scoreB = intval($score[1]);

		//Find the teams
		$teamA = $html->find('.content-column .content .left a', 0);
		$teamB = $html->find('.content-column .content .right a', 0);

		$this->teams[$teamA->plaintext] = 'http://int.soccerway.com' . $teamA->href;
		$this->teams[$teamB->plaintext] = 'http://int.soccerway.com' . $teamB->href;

		//Get the countries from these teams
		$countryIdTeamA = $this->findTeamCountry('http://int.soccerway.com' . $teamA->href);
		$countryIdTeamB = $this->findTeamCountry('http://int.soccerway.com' . $teamB->href);

		//Add the teams to the database
		$teamIdA = $this->database->addTeam($teamA->plaintext, $countryIdTeamA);
		$teamIdB = $this->database->addTeam($teamB->plaintext, $countryIdTeamB);

		//Add the match to the database
		$date = $html->find('.middle .details dd', 1)->plaintext;
		$matchId = $this->database->addMatch($teamIdA, $teamIdB, $scoreA, $scoreB, $refereeId, $date, $tournamentId);

		echo "match: $matchId<br>";

		$teams = array(
			'teamA' => array(
				'block' => $html->find('.block_match_lineups .left tbody', 0),
				'id' => $teamIdA
			),

			'teamB' => array(
				'block' => $html->find('.block_match_lineups .right tbody', 0),
				'id' => $teamIdB
			),
		);

		//Find all players and add them to the database
		foreach ($teams as $team) {

			if(!is_object($team['block'])) {
				continue;
			}

			foreach ($team['block']->find('tr') as $row) {

				$number = 0;

				$player = $row->find('.player a', 0);
				if (sizeof($player) > 0) {

					$number++;

					//Add the player to the database
					$shirtNumber = $row->find('.shirtnumber', 0);

					if(!is_object($shirtNumber)) {
						$shirtNumber = $number;
					}
					else {
						$shirtNumber = intval($shirtNumber->plaintext);
					}

					$playerId = $this->parsePlayer('http://int.soccerway.com' . $player->href);
					$this->database->addPlayerToMatch($playerId, $matchId, $team['id'], $shirtNumber);



					//Add the yellow and red cards
					$bookings = $row->find('.bookings span');
					foreach ($bookings as $booking) {


						$time = intval($booking->plaintext);
						$img = $booking->find('img', 0)->getAttribute('src');
						if (preg_match('/http:\/\/s1\.swimg\.net\/gsmf\/[0-9]{3}\/img\/events\/YC\.png/', $img)) {
							$type = Card::yellow;
						}
						else if (preg_match('/http:\/\/s1\.swimg\.net\/gsmf\/[0-9]{3}\/img\/events\/Y2C\.png/', $img)) {
							$type = Card::yellow;
						}
						else if (preg_match('/http:\/\/s1\.swimg\.net\/gsmf\/[0-9]{3}\/img\/events\/RC\.png/', $img)) {
							$type = Card::red;
						}
						else {
							//echo "<em>Parser found unknown card image: $img</em></br>";
							continue;
						}

						$this->database->addFoulCard($playerId, $matchId, $time, $type);
					}

				}
			}

			//Also add the coach
			$coach = $team['block']->find('tr a', -1);
			$coachId = $this->parseCoach('http://int.soccerway.com' . $coach->href);
			$this->database->addCoaches($coachId, $team['id'], $matchId);
		}

		//Find the goals
		$rawGoals = $html->find('.block_match_goals', 0);
		if(gettype($rawGoals) != 'NULL') {

			$goals = array();
			foreach ($rawGoals->find('.player') as $player) {
				if(sizeof($player->find('.minute', 0)) > 0) {
					$playerName = $player->find('a', 0);
					$time = $player->find('.minute', 0)->plaintext;
					$goals[intval($time)] = $playerName;
				}
			}

			foreach ($goals as $time => $player) {
				$playerId = $this->parsePlayer('http://int.soccerway.com' . $player->href);
				$this->database->addGoal($playerId, $time, $matchId);
			}
		}

		$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
	}


	/**
	Parse the information about the referee and add it to the database

	@return id of the referee
	*/
	private function parseReferee($url) {

		$html = $this->loadPage($url);

		$firstName = htmlspecialchars($html->find('.content .first dd', 0)->plaintext);
		$lastName = htmlspecialchars($html->find('.content .first dd', 1)->plaintext);
		$country = $html->find('.content .first dd', 2)->plaintext;

		$countryId = $this->database->addCountry($country);
		$refereeId = $this->database->addReferee($firstName, $lastName, $countryId);

		$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)

		return $refereeId;
	}


	/**
	Parse the information about the player and add it to the database

	@return id of the player
	*/
	private function parsePlayer($url) {

		$html = $this->loadPage($url);

		$firstName = $html->find('.content .first dd', 0)->plaintext;
		$lastName = $html->find('.content .first dd', 1)->plaintext;
		$country = $html->find('.content .first dd', 2)->plaintext;

		$countryId = $this->database->addCountry($country);
		$playerId = $this->database->addPlayer($firstName, $lastName, $countryId);

		$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)

		return $playerId;
	}


	/**
	Parse the information about the coach and add it to the database

	@return id of the coach
	*/
	private function parseCoach($url) {

		$html = $this->loadPage($url);

		$firstName = $html->find('.content .first dd', 0)->plaintext;
		$lastName = $html->find('.content .first dd', 1)->plaintext;
		$country = $html->find('.content .first dd', 2)->plaintext;

		$countryId = $this->database->addCountry($country);
		$coachId = $this->database->addCoach($firstName, $lastName, $countryId);

		$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)

		return $coachId;
	}


	/**
	Look for the country of the team and add it to the database

	@return id of the country
	*/
	private function findTeamCountry($url) {

		$html = $this->loadPage($url);

		$properties = $html->find('.first-element .content .fully-padded dt');
		$values = $html->find('.first-element .content .fully-padded dd');

		if (sizeof($properties) != sizeof($values)) {
			$html->clear();
			throw new Exception('Table does not have equal amounts of dt and dd tags.');
		}

		for($i = 0; $i < count($properties); $i++) {

			if ($properties[$i]->plaintext != 'Country')
				continue;

			$country = $values[$i]->plaintext;
			$countryId = $this->database->addCountry($country);

			$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)

			return $countryId;
		}

		$html->clear();
		throw new Exception('Failed to determine country of team.');
	}

};


set_time_limit(0);


$p = new Parser;
$p->parse();


?>
