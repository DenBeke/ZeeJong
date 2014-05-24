<?php
/*
Script for fetching and parsing html pages


Created: February 2014
*/

require_once( dirname(__FILE__) . '/simple_html_dom.php' );
require_once( dirname(__FILE__) . '/database.php' );
require_once( dirname(__FILE__) . '/classes/Card.php' );
require_once( dirname(__FILE__) . '/betHandler.php' );

/**
@brief Class for parsing the archives.
*/
class Parser {

    private $competition;
    private $tournament;

    private $database;

    private $teams = array();

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

                'be-sec' => array(
                    'name' => 'Belgium Second Division',
                    'url' => 'http://int.soccerway.com/national/belgium/second-division/20132014/regular-season/r21592/'
                ),

                'bundesliga' => array(
                    'name' => 'Bundesliga',
                    'archiveUrl' => 'http://int.soccerway.com/national/germany/bundesliga/c9/archive/?ICID=PL_3N_07',
                    'url' => 'http://int.soccerway.com/national/germany/bundesliga/20132014/regular-season/r21344/?ICID=SN_01_02'
                ),

                'premier' => array(
                    'name' => 'Premier League',
                    'url' => 'http://int.soccerway.com/national/england/premier-league/20132014/regular-season/r21322/'
                ),

                'eredivisie' => array(
                    'name' => 'Eredivisie',
                    'url' => 'http://int.soccerway.com/national/netherlands/eredivisie/20132014/regular-season/r21384/'
                ),

                'it-serie-a' => array(
                    'name' => 'Serie A',
                    'url' => 'http://int.soccerway.com/national/italy/serie-a/20132014/regular-season/r21388/?ICID=SN_01_03'
                ),

                'primera' => array(
                    'name' => 'Primera División',
                    'url' => 'http://int.soccerway.com/national/spain/primera-division/20132014/regular-season/r21879/?ICID=SN_01_04'
                ),

                'ligue-1' => array(
                    'name' => 'Ligue 1',
                    'url' => 'http://int.soccerway.com/national/france/ligue-1/20132014/regular-season/r21342/?ICID=TN_02_01_05'
                ),

                'süper-lig' => array(
                    'name' => 'Süper Lig',
                    'url' => 'http://int.soccerway.com/national/turkey/super-lig/20132014/regular-season/r21433/?ICID=SN_01_07'
                ),

                'primeira' => array(
                    'name' => 'Primeira Liga',
                    'url' => 'http://int.soccerway.com/national/portugal/portuguese-liga-/20132014/regular-season/r21831/?ICID=TN_02_01_08'
                ),

                'championship' => array(
                    'name' => 'Championship',
                    'url' => 'http://int.soccerway.com/national/england/championship/20132014/regular-season/r21389/'
                ),

                'br-serie-a' => array(
                    'name' => 'Serie A',
                    'url' => 'http://int.soccerway.com/national/brazil/serie-a/2014/regular-season/r24110/?ICID=TN_02_01_10'
                ),

                'africa' => array(
                    'name' => 'Africa Cup of Nations',
                    'url' => 'http://int.soccerway.com/international/africa/africa-cup-of-nations/2014/group-stage/r19328/'
                ),

                'russia' => array(
                    'name' => 'Russia Premier League',
                    'url' => 'http://int.soccerway.com/national/russia/premier-league/20132014/regular-season/r21457/'
                ),

                'usa' => array(
                    'name' => 'Major League Soccer',
                    'url' => 'http://int.soccerway.com/national/united-states/mls/2014/regular-season/r23603/'
                ),

                'chinese' => array(
                    'name' => 'Chinese Super League',
                    'url' => 'http://int.soccerway.com/national/china-pr/csl/2014/regular-season/r23926/'
                ),

                'afc' => array(
                    'name' => 'AFC Champions League',
                    'url' => 'http://int.soccerway.com/international/asia/afc-champions-league/2014/group-stage/r23286/'
                ),

                'caf' => array(
                    'name' => 'CAF Champions League',
                    'url' => 'http://int.soccerway.com/international/africa/caf-champions-league/2014/group-stage/r23522/'
                )
            );
    }


    /**
    Parse the competitions to fill in new data.
    */
    public function parse($ttl = 7200) {

        $this->ttl = $ttl;

        //Loop through competition and parse the competitions
        foreach ($this->competitions as $competition) {

            $this->competition = $competition['name'];

            echo '<em>Parsing: ' . $competition['name'] . '</em><br>';
            $this->parseNewMatches($competition['url']);
        }
    }


    /**
    Load a page, but take the one from the cache when already loaded.

    @param url of the page

    @return DOM object
    */
    private function loadPage($url) {

        $filename = dirname(__FILE__) . '/cache/' . md5($url) . '.cache';

        //Try to use the cache
        if ($this->ttl >= 0 && file_exists($filename)) {

            if ($this->ttl == 0 || time() - filemtime($filename) <= $this->ttl) {
                return file_get_html($filename);
            }
        }

        //Download the page
        $try = 0;
        $page = FALSE;
        while ($page == FALSE && $try < 50) {
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
    Parse the match in the archive and store the data.

    @param url of the match
    */
    private function parseMatch($url, $type = '') {

        try {

            //Add the competition and tournament to the database
            $competitionId = $this->database->addCompetition($this->competition);
            $tournamentId = $this->database->addTournament($this->tournament, $competitionId);

            $html = $this->loadPage($url);

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

            //Parse the team pages
            $teamIdA = $this->parseTeam('http://int.soccerway.com' . $teamA->href);
            $teamIdB = $this->parseTeam('http://int.soccerway.com' . $teamB->href);

            //Add the match to the database
            $date = $html->find('.middle .details .timestamp', 1)->getAttribute('data-value');
            $matchId = $this->database->addMatch($teamIdA, $teamIdB, $scoreA, $scoreB, $refereeId, $date, $tournamentId, $type);

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

        catch (exception $e) {
            echo 'Exception in parseMatch: ' . $e->getMessage() . '<br>';
            $html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
        }
    }


    /**
    Parse new matches.

    @param url of the competition
    */
    private function parseNewMatches($original_url) {

        $html = $this->loadPage($original_url);

        $competitionId = $this->database->addCompetition($this->competition);

        $this->tournament = $html->find('.level-1 a', 0)->plaintext;
        $tournamentId = $this->database->addTournament($this->tournament, $competitionId);

        $urls = array();
        $parts = $html->find('.level-1', 0)->find('.leaf a');
        foreach ($parts as $part) {

            $paramPos = strpos($part->href, '?');
            if ($paramPos == FALSE) {
                $urls[] = 'http://int.soccerway.com' . $part->href . 'matches/';
            }
            else {
                $urls[] = substr($part->href, 0, $paramPos) . 'matches/' . substr($part->href, $paramPos);
            }
        }

        if (sizeof($urls) < 2) {
            $paramPos = strpos($original_url, '?');
            if ($paramPos == FALSE) {
                $urls = [$original_url . 'matches/'];
            }
            else {
                $urls = [substr($original_url, 0, $paramPos) . 'matches/' . substr($original_url, $paramPos)];
            }
        }

        $html->clear();

        foreach ($urls as $url) {

            try {
                $html = $this->loadPage($url);
            }
            catch (Exception $e) {
                echo 'Exception: Failed to load ' . $url . '<br>';
            }

            //Loop over all matches
            $blocksFound = true;
            $blocks = $html->find('div.block_competition_matches_full-wrapper');
            if (sizeof($blocks) == 0) {
                $blocks = [$html];
                $blocksFound = false;
            }
            foreach ($blocks as $block) {

                $type = '';
                if ($blocksFound) {
                    $typeTag = $block->find('h2');
                    if (sizeof($typeTag) == 1) {
                        $type = $typeTag[0]->plaintext;
                    }
                }

                $rows = $block->find('.table-container .matches tr');
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

                        if (!isset($teamA) || !isset($teamB) || !isset($scoreOrTime)) {
                            continue;
                        }

                        //Parse the team pages
                        $teamIdA = $this->parseTeamFast('http://int.soccerway.com' . $teamA->href);
                        $teamIdB = $this->parseTeamFast('http://int.soccerway.com' . $teamB->href);

                        //Find out if the match has been played already or not
                        $colonPos = strpos(trim($scoreOrTime), ' : ');
                        $minusPos = strpos(trim($scoreOrTime), ' - ');
                        if ($colonPos != $minusPos) {

                            if ($colonPos != false) {
                                try {
                                    $this->database->getMatch($teamIdA, $teamIdB, $date, $tournamentId);
                                }
                                catch (Exception $e) {
                                    $teamIdA = $this->parseTeam('http://int.soccerway.com' . $teamA->href);
                                    $teamIdB = $this->parseTeam('http://int.soccerway.com' . $teamB->href);

                                    $this->database->addMatch($teamIdA, $teamIdB, -1, -1, null, $date, $tournamentId, $type);
                                }
                            }
                            else {

                                try {
                                    $match = $this->database->getMatch($teamIdA, $teamIdB, $date, $tournamentId);

                                    //There is no need to parse the match again if it had a score already
                                    if ($match->getScoreId() != null) {
                                        continue;
                                    }

                                    $matchId = $match->getId();
                                    $this->database->removeMatch($matchId);
                                }
                                catch (Exception $e) {
                                }

                                //Add the match
                                $matchUrl = $row->find('.score-time a', 0)->href;
                                $this->parseMatch('http://int.soccerway.com' . $matchUrl, $type);
                            }
                        }
                    }
                }
            }

            $html->clear(); //Clear DOM tree (memory leak in simple_html_dom)
        }
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

        if (file_exists('../images/Referee-' . $refereeId . '.png') == FALSE)
        {
            $imageUrl = $html->find('.content .yui-u img', 0)->src;
            $image = file_get_contents($imageUrl);
            file_put_contents( dirname(__FILE__) . '/../images/Referee-' . $refereeId . '.png', $image);
        }

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
        $playerId = $this->database->addPlayer($firstName, $lastName, $countryId, $dateOfBirth, $height, $weight, $position);

        if (file_exists('../images/Player-' . $playerId . '.png') == FALSE)
        {
            $imageUrl = $html->find('.content .yui-u img', 0)->src;
            $image = file_get_contents($imageUrl);
            file_put_contents( dirname(__FILE__) . '/../images/Player-' . $playerId . '.png', $image);
        }

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

        if (file_exists('../images/Coach-' . $coachId . '.png') == FALSE)
        {
            $imageUrl = $html->find('.content .yui-u img', 0)->src;
            $image = file_get_contents($imageUrl);
            file_put_contents( dirname(__FILE__) . '/../images/Coach-' . $coachId . '.png', $image);
        }

        $html->clear(); //Clear DOM tree (memory leak in simple_html_dom)

        return $coachId;
    }


    /**
    Parse the team just to get its id

    @return id of the team
    */
    private function parseTeamFast($url) {

        $html = $this->loadPage($url);

        $name = $html->find('#subheading h1', 0)->plaintext;
        $countryId = $this->findTeamCountry($html);

        $id = $this->database->addTeam($name, $countryId);

        $html->clear();
        return $id;
    }


    /**
    Parse the information about the team and add it to the database

    @return id of the team
    */
    private function parseTeam($url) {

        $html = $this->loadPage($url);

        $name = $html->find('#subheading h1', 0)->plaintext;
        $countryId = $this->findTeamCountry($html);

        $id = $this->database->addTeam($name, $countryId);

        if ((array_key_exists($name, $this->teams) == FALSE) || ($this->teams[$name] == FALSE)) {
            if (!file_exists('../images/Team-' . $id . '.png')) {
                $imageUrl = $html->find('.content .logo img', 0)->src;
                $image = file_get_contents($imageUrl);
                file_put_contents(dirname(__FILE__) . '/../images/Team-' . $id . '.png', $image);
            }

            $this->parsePlayersInTeams($html, $id);
            $this->teams[$name] = TRUE;
        }

        $html->clear();
        return $id;
    }


    /**
    Parse the team page and fill the PlaysIn table

    @return id of the team
    */
    private function parsePlayersInTeams($html, $teamId) {

        //Remove all players from this team
        $this->database->removePlayersFromTeam($teamId);

        //Add the current players to the team
        $table = $html->find('.squad-container table', 0);
        if (is_object($table)) {

            foreach ($table->children() as $table_row) {

                if ($table_row->tag == 'thead') {

                    if (trim($table_row->plaintext) == 'Coach') {

                        // Parse the coach ($table_row->next_sibling())

                        if ($table_row->next_sibling() == null) {
                            $html->clear();
                            throw new Exception('Head coach was found but not its body?');
                        }

                        if ($table_row->next_sibling()->next_sibling() != null) {
                            $html->clear();
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
        }
    }


    /**
    Look for the country of the team and add it to the database

    @return id of the country
    */
    private function findTeamCountry($html) {

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

            return $countryId;
        }

        $html->clear();
        throw new Exception('Failed to determine country of team.');
    }

};


set_time_limit(0);


$p = new Parser;
$p->parse();


$betHandler = new BetHandler;
$betHandler -> genBetsToProcess();
$betHandler -> processBets();

?>
