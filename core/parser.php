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

	private $competitions;


	/**
	@brief Constructor of the parser object.
	*/
	public function __construct() {
		$this->database = new Database();

		date_default_timezone_set('Europe/Brussels');

		$this->competitions = array(

				'wk' => array(
					'name' => 'World Cup',
					'archiveUrl' => 'http://int.soccerway.com/international/world/world-cup/c72/archive/?ICID=PL_3N_06',
					'url' => 'http://int.soccerway.com/international/world/world-cup/2014-brazil/group-stage/r16351/?ICID=PL_3N_01'
				),

				'eu' => array(
					'name' => 'European Championship',
					'archiveUrl' => 'http://int.soccerway.com/international/europe/european-championships/c25/archive/?ICID=PL_3N_05',
					'url' => 'http://int.soccerway.com/international/europe/european-championships/2012-poland-ukraine/s4943/final-stages/?ICID=TN_02_03_03'
				),

				'olympics' => array(
					'name' => 'Olympics',
					'archiveUrl' => 'http://int.soccerway.com/international/world/olympics/c221/archive/?ICID=PL_3N_04',
					'url' => 'http://int.soccerway.com/international/world/olympics/2012-london/s6606/final-stages/?ICID=TN_02_03_02'
				),

				'uefa-champions' => array(
					'name' => 'UEFA Champions League',
					'archiveUrl' => 'http://int.soccerway.com/international/europe/uefa-champions-league/c10/archive/?ICID=PL_3N_04',
					'url' => 'http://int.soccerway.com/international/europe/uefa-champions-league/20132014/s8381/final-stages/?ICID=SN_03_08'
				),

				'uefa-eu' => array(
					'name' => 'UEFA Europa League',
					'archiveUrl' => 'http://int.soccerway.com/international/europe/uefa-cup/c18/archive/?ICID=PL_3N_04',
					'url' => 'http://int.soccerway.com/international/europe/uefa-cup/20132014/s8295/final-stages/?ICID=TN_02_02_02'
				),

				'be-pro' => array(
					'name' => 'Belgium Pro League',
					'archiveUrl' => 'http://int.soccerway.com/national/belgium/pro-league/c24/archive/?ICID=PL_3N_07',
					'url' => 'http://int.soccerway.com/national/belgium/pro-league/20132014/regular-season/r21451/?ICID=HP_POP_11'
				),

				'bundesliga' => array(
					'name' => 'Bundesliga',
					'archiveUrl' => 'http://int.soccerway.com/national/germany/bundesliga/c9/archive/?ICID=PL_3N_07',
					'url' => 'http://int.soccerway.com/national/germany/bundesliga/20132014/regular-season/r21344/?ICID=SN_01_02'
				)
			);
	}


	/**
	Parse the competitions to fill in new data.
	*/
	public function parse($ttl = 1000) {

		$this->ttl = $ttl;

		//Loop through competition and parse the competitions
		foreach ($this->competitions as $competition) {

			$this->competition = $competition['name'];

			echo '<em>Parsing: ' . $competition['name'] . '</em><br>';
			$this->parseNewMatches($competition['url']);
		}

		//Refresh the PlaysIn table
		$this->parsePlayersInTeams();
	}


	/**
	Parse the archive and store the data.
	*/
	public function parseArchive($ttl = 0) {

		$this->ttl = $ttl;

		//Loop through competition and parse the competitions
		foreach ($this->competitions as $competition) {

			$this->competition = $competition['name'];

			echo '<em>Parsing: ' . $competition['name'] . '</em><br>';
			$this->parseCompetitionInArchive($competition['archiveUrl']);
		}

		//Refresh the PlaysIn table
		$this->parsePlayersInTeams();
	}


	/**
	Find out which players are currently playing for which team.
	*/
	private function parsePlayersInTeams() {

		if (sizeof($this->teams) == 0)
			return;

		//Loop over the urls and find the players
		$url_list = array_values($this->teams);
		foreach ($url_list as $url) {

			$html = $this->loadPage($url);

			$countryId = $this->findTeamCountry($url);
			$teamName = $html->find('#subheading h1', 0)->plaintext;
			$teamId = $this->database->addTeam($teamName, $countryId);

			//Remove all players from this team
			$this->database->removePlayersFromTeam($teamId);

			//Add the current players to the team
			$table = $html->find('.squad-container table', 0);
			foreach ($table->children() as $table_row) {

				if ($table_row->tag == 'thead') {

					if (trim($table_row->plaintext) == 'Coach') {

						// Parse the coach ($table_row->next_sibling())

						if ($table_row->next_sibling() == null) {
							throw new Exception('Head coach was found but not its body?');
						}

						if ($table_row->next_sibling()->next_sibling() != null) {
							throw new Exception('Table contains data after coach. Code has to be improved.');
						}

						break;
					}
				}

				if ($table_row->tag == 'tbody') {

					$rows = $table_row->find('tr');
					foreach ($rows as $row) {

						$player = $row->find('td a', 1);
						if (is_object($player)) {
							$playerId = $this->parsePlayer('http://int.soccerway.com' . $player->href);
							$this->database->addPlayerToTeam($playerId, $teamId);
						}

						$player = $row->find('td a', 3);
						if (is_object($player)) {
							$playerId = $this->parsePlayer('http://int.soccerway.com' . $player->href);
							$this->database->addPlayerToTeam($playerId, $teamId);
						}
					}
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
		while ($page == FALSE && $try < 10) {
			$page = file_get_contents($url);
			$try += 1;

			if ($page == FALSE) {
				usleep(10000000);
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
	private function parseCompetitionInArchive($url) {

		$html = $this->loadPage($url);

		//Find all tournaments
		foreach($html->find('.season a') as $element) {

			$tournamentName = $element->plaintext;
			$tournamentUrl = $element->href;

			$this->tournament = $tournamentName;

			echo "<h2>$tournamentName</h2>";

			$this->parseTournamentInArchive('http://int.soccerway.com' . $tournamentUrl);

		}

		$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
	}


	/**
	Parse the tournaments in the archive and store the data.

	@param url of the tournament
	*/
	private function parseTournamentInArchive($url) {

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
		$date = strtotime($html->find('.middle .details dd', 1)->plaintext);
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

						$time = 0;
						$time_parts = explode('+', $booking->plaintext);
						foreach ($time_parts as $part) {
							$time += intval($part);
						}

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

					$time = 0;
					$time_parts = explode('+', $player->find('.minute', 0)->plaintext);
					foreach ($time_parts as $part) {
						$time += intval($part);
					}

					$playerName = $player->find('a', 0);
					$goals[$time] = $playerName;
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
	Parse new matches.

	@param url of the competition
	*/
	private function parseNewMatches($url) {

		$html = $this->loadPage($url);

		$competitionId = $this->database->addCompetition($this->competition);

		//Find the tournament
		$this->tournament = $html->find('.level-1 a', 0)->plaintext;
		$tournamentId = $this->database->addTournament($this->tournament, $competitionId);

		//Loop over all matches
		$rows = $html->find('.table-container .matches tr');
		foreach ($rows as $row) {

			//Some results are not matches and should be skipped
			$date = $row->find('.date', 0);
			if ((is_object($date)) && ($date->tag == 'td')) {

				//Convert the date in something that strtotime understands
				$date = $date->plaintext;
				$date = explode('/', $date);
				$date[2] = '20' . $date[2];
				$date = implode('-', $date);

				$date = strtotime($date);

				//Read the information about the match
				$teamA = $row->find('.team-a a', 0);
				$teamB = $row->find('.team-b a', 0);
				$scoreOrTime = $row->find('.score-time', 0)->plaintext;

				//Store the teams
				$this->teams[$teamA->plaintext] = 'http://int.soccerway.com' . $teamA->href;
				$this->teams[$teamB->plaintext] = 'http://int.soccerway.com' . $teamB->href;

				//Get the countries from these teams
				$countryIdTeamA = $this->findTeamCountry('http://int.soccerway.com' . $teamA->href);
				$countryIdTeamB = $this->findTeamCountry('http://int.soccerway.com' . $teamB->href);

				//The names of the teams are truncated, find the full names
				$teamA = $this->findFullTeamName('http://int.soccerway.com' . $teamA->href);
				$teamB = $this->findFullTeamName('http://int.soccerway.com' . $teamB->href);

				//Add the teams to the database
				$teamIdA = $this->database->addTeam($teamA, $countryIdTeamA);
				$teamIdB = $this->database->addTeam($teamB, $countryIdTeamB);

				//Find out if the match has been played already or not
				$colonPos = strpos(trim($scoreOrTime), ' : ');
				$minusPos = strpos(trim($scoreOrTime), ' - ');
				if ($colonPos == $minusPos) {
					throw new Exception('Failed to parse time or score of match');
				}

				if ($colonPos != false) {
					$this->database->addMatch($teamIdA, $teamIdB, -1, -1, null, $date, $tournamentId);
				}
				else {

					try {
						$matchId = $this->database->getMatch($teamIdA, $teamIdB, null, $date, $tournamentId);

						//If no exception gets thrown then the match was already in the database
						$this->database->removeMatch($matchId);
					}
					catch (Exception $e) {
					}

					//Add the match
					$matchUrl = $row->find('.score-time a', 0)->href;
					$this->parseMatch('http://int.soccerway.com' . $matchUrl);
				}
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

		$firstName = null;
		$lastName = null;
		$country = null;
		$dateOfBirth = null;
		$height = null;
		$weight = null;
		$position = null;

		$html = $this->loadPage($url);
		$imageUrl = $html->find('.content .yui-u img', 0)->src;

		//Loop over the properties
		$properties = $html->find('.content .first dt');
		foreach ($properties as $property) {

			//Find the value of the properties
			$value = $property->next_sibling();
			if (is_object($value) == FALSE || $value->tag != 'dd') {
				throw new Exception('Failed to find the corresponding dd tag of the dt tag.');
			}

			//Fill the data with what we read
			switch ($property->plaintext) {

				case 'First name':
					$firstName = $value->plaintext;
					break;

				case 'Last name':
					$lastName = $value->plaintext;
					break;

				case 'Nationality':
					$country = $value->plaintext;
					break;

				case 'Date of birth':
					$dateOfBirth = strtotime($value->plaintext);
					break;

				case 'Height':
					$height = intval($value->plaintext);
					break;

				case 'Weight':
					$weight = intval($value->plaintext);
					break;

				case 'Position':
					$position = $value->plaintext;
					break;
			}
		}

		$countryId = $this->database->addCountry($country);
		$playerId = $this->database->addPlayer($firstName, $lastName, $countryId, $dateOfBirth, $height, $weight, $position, $imageUrl);

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
	Look for the full name of the team

	@return name of the team
	*/
	private function findFullTeamName($url) {

		$html = $this->loadPage($url);

		$name = $html->find('#subheading h1', 0)->plaintext;

		$html->clear();

		return $name;
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
