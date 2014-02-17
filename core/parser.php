<?php
/*
Script for fetching and parsing html pages


Created: February 2014
*/


require_once( dirname(__FILE__) . '/simple_html_dom.php' );
require_once( dirname(__FILE__) . '/database.php' );


/**
@brief Class for parsing the archives.
*/
class Parser {

	private $competition;
	private $tournament;

	private $database;


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
	}


	/**
	Parse the competitions in the archive and store the data.

	@param url of the competition
	*/
	private function parseCompetition($url) {

		$html = file_get_html($url);

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

		$html = file_get_html($url);

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

		$html = file_get_html($url);

		//Add the competition and tournament to the database
		$competitionId = $this->database->addCompetition($this->competition);
		$tournamentId = $this->database->addTournament($this->tournament, $competitionId);

		//Find the referee
		$refereeId = $this->parseReferee('http://int.soccerway.com' . $html->find('.referee', 0)->href);

		//Find the final score
		$score = $html->find('#subheading .bidi', 0)->plaintext;
		$score = explode(' - ', $score);
		$scoreA = intval($score[0]);
		$scoreB = intval($score[1]);

		//Find the teams
		$teamA = $html->find('.content-column .content .left a', 0);
		$teamB = $html->find('.content-column .content .right a', 0);

		//Get the countries from these teams
		$countryIdTeamA = $this->findTeamCountry('http://int.soccerway.com' . $teamA->href);
		$countryIdTeamB = $this->findTeamCountry('http://int.soccerway.com' . $teamB->href);

		//Add the teams to the database
		$teamIdA = $this->database->addTeam($teamA->plaintext, $countryIdTeamA);
		$teamIdB = $this->database->addTeam($teamB->plaintext, $countryIdTeamB);

		//Add the match to the database
		$date = $html->find('.middle .details dd', 1)->plaintext;
		$matchId = $this->database->addMatch($teamA->plaintext, $teamB->plaintext, $scoreA, $scoreB, $refereeId, $date, $tournamentId);

		//Find all players from team A and add them to the database
		$block = $html->find('.block_match_lineups > div', 0);
		foreach ($block->find('.player a') as $player) {
			$playerId = $this->parsePlayer('http://int.soccerway.com' . $player->href);
			$this->database->addPlayerToMatch($playerId, $matchId, $teamIdA);
		}

		//Parse the coach of team A
		$coach = $block->find('tr a', -1);
		$this->parseCoach('http://int.soccerway.com' . $coach->href);

		//Find all players from team B and add them to the database
		$block = $html->find('.block_match_lineups > div', 1);
		foreach ($block->find('.player a') as $player) {
			$this->parsePlayer('http://int.soccerway.com' . $player->href);
			$this->database->addPlayerToMatch($playerId, $matchId, $teamIdB);
		}

		//Parse the coach of team B
		$coach = $block->find('tr a', -1);
		$this->parseCoach('http://int.soccerway.com' . $coach->href);

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

		$html = file_get_html($url);

		$firstName = $html->find('.content .first dd', 0)->plaintext;
		$lastName = $html->find('.content .first dd', 1)->plaintext;
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

		$html = file_get_html($url);

		$firstName = $html->find('.content .first dd', 0)->plaintext;
		$lastName = $html->find('.content .first dd', 1)->plaintext;

		$playerId = $this->database->addPlayer($firstName, $lastName);

		$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)

		return $playerId;
	}


	/**
	Parse the information about the coach and add it to the database

	@return id of the coach
	*/
	private function parseCoach($url) {

		$html = file_get_html($url);

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

		$html = file_get_html($url);

		$country = $html->find('.first-element .content .fully-padded dd', 2)->plaintext;

		$countryId = $this->database->addCountry($country);

		$html->clear(); //Clear DOM tree (memory leak in simple_html_dom)

		return $countryId;
	}

};


?>
