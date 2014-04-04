<?php
/*
Importer of JSON input,
parsed by the GO parser.

Created: April 2014
*/

ini_set('memory_limit', '256M');


require_once(dirname(__FILE__) . '/database.php');


$db = new Database;


$filename = "output.json";
$data = json_decode(file_get_contents($filename), true);




//Database and JSON schama
//This links the json file to database tables and columns
$schama = [

	//Countries
	[
		'json' => 'Countries',
		'db' => 'Country',
		'cols' => [
			'Id' => 'id',
			'Name' => 'name'
		]
	],
	
	//Players
	[
		'json' => 'Players',
		'db' => 'Player',
		'cols' => [
			'Id' => 'id',
			'Firstname' => 'firstname',
			'Lastname' => 'lastname',
			'Country' => 'country',
			'DateOfBirth' => 'dateOfBirth',
			'Height' => 'height',
			'Weight' => 'weight',
			'Position' => 'position'
		]
	],
	
	//Teams
	[
		'json' => 'Teams',
		'db' => 'Team',
		'cols' => [
			'Id' => 'id',
			'Name' => 'name',
			'CountryId' => 'country'
		]
	],
	
	//Coaches
	[
		'json' => 'Coaches',
		'db' => 'Coach',
		'cols' => [
			'Id' => 'id',
			'Firstname' => 'firstname',
			'Lastname' => 'lastname',
			'Country' => 'country',
		]
	],
	
	//Referees
	[
		'json' => 'Referees',
		'db' => 'Referee',
		'cols' => [
			'Id' => 'id',
			'Firstname' => 'firstname',
			'Lastname' => 'lastname',
			'Country' => 'countryId',
		]
	],
	
	//Add competitions
	[
		'json' => 'Competitions',
		'db' => 'Competition',
		'cols' => [
			'Id' => 'id',
			'Name' => 'name',
		]
	],
	
	//Add tournaments
	[
		'json' => 'Seasons',
		'db' => 'Tournament',
		'cols' => [
			'Id' => 'id',
			'Name' => 'name',
			'CompetitionId' => 'competitionId'
		]
	],

	//Add matches
	[
		'json' => 'Matches',
		'db' => 'Match',
		'cols' => [
			'Id' => 'id',
			'TeamA' => 'teamA',
			'TeamB' => 'teamB',
			'Season' => 'tournamentId',
			'Referee' => 'refereeID',
			'Date' => 'date',
			'Score' => 'scoreID'
		]
	],
	
	//Add playsMatchInteam
	[
		'json' => 'PlaysMatchInTeams',
		'db' => 'PlaysMatchInTeam',
		'cols' => [
			'Id' => 'id',
			'PlayerId' => 'playerId',
			'TeamId' => 'teamId',
			'MatchId' => 'matchId'
		]
	],
	
	//Add Coacheses
	[
		'json' => 'Coacheses',
		'db' => 'Coacheses',
		'cols' => [
			'Id' => 'id',
			'CoachId' => 'coachId',
			'TeamId' => 'teamId',
			'MatchId' => 'matchId'
		]
	],
	
	
	//Add playsIn
	
	
	//Add referee for match
	
	
	//Add goals
	
	
	//Add cards

];



//Add all json objects to the database

foreach ($schama as $meta) {
	
	$table = $meta['db'];
	$json = $meta['json'];
	
	
	//Empty table
	$db->truncate($table);
	
	foreach ($data[$json] as $set) {
		$values = [];
		$attributes = [];
		foreach ($meta['cols'] as $key => $value) {
			$values[] = $set[$key];
			$attributes[] = $value;
		}
		$db->insert($table, $attributes, $values);
	}
	
	echo 'Added ' . sizeof($data[$json]) . ' items to `' . $table . '`<br>';
}




?>