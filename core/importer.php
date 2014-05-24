<?php
/*
Importer of JSON input,
parsed by the GO parser.

Created: April 2014
*/

ini_set('memory_limit', '1G');
ini_set('max_execution_time', 0);


require_once(dirname(__FILE__) . '/database.php');



function import($filename = 'output.json') {


    $db = new Database;
    $data = json_decode(file_get_contents($filename), true);

    if($data == NULL) {
        throw new exception("Could not decode input file.");
    }


    //Database and JSON schama
    //This links the json file to database tables and columns
    $schema = [

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
        
        //Add score
        [
            'json' => 'Scores',
            'db' => 'Score',
            'cols' => [
                'Id' => 'id',
                'TeamA' => 'teamA',
                'TeamB' => 'teamB',
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
                'Score' => 'scoreID',
                'FinalType' => 'type'
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
                'MatchId' => 'matchId',
                'Number' => 'number'
            ]
        ],

        //Add Coacheses
        [
            'json' => 'Coacheses',
            'db' => 'Coaches',
            'cols' => [
                'Id' => 'id',
                'CoachId' => 'coachId',
                'TeamId' => 'teamId',
                'MatchId' => 'matchId'
            ]
        ],


        //Add playsIn
        [
            'json' => 'PlaysIn',
            'db' => 'PlaysIn',
            'cols' => [
                'Id' => 'id',
                'TeamId' => 'teamId',
                'PlayerId' => 'playerId'
            ]
        ],



        //Add goals
        [
            'json' => 'Goals',
            'db' => 'Goal',
            'cols' => [
                'Id' => 'id',
                'MatchId' => 'matchId',
                'PlayerId' => 'playerId',
                'Time' => 'time'
            ]
        ],


        //Add cards
        [
            'json' => 'Cards',
            'db' => 'Cards',
            'cols' => [
                'Id' => 'id',
                'MatchId' => 'matchId',
                'PlayerId' => 'playerId',
                'Time' => 'time',
                'Type' => 'color'
            ]
        ],
    ];



    //Output table
    $output = [];



    //Add all json objects to the database
    foreach ($schema as $meta) {

        $table = $meta['db'];
        $json = $meta['json'];


        foreach ($data[$json] as $set) {
            $values = [];
            $attributes = [];
            foreach ($meta['cols'] as $key => $value) {
                
                if($value == 'refereeID') {
                
                    if($set[$key] === 0) {
                        $values[] = NULL;
                        $attributes[] = $value;
                    }
                    else {
                        $values[] = $set[$key];
                        $attributes[] = $value;

                    }
                
                }
                else {
                    $values[] = $set[$key];
                    $attributes[] = $value;
                }
                
            }
            $db->insert($table, $attributes, $values);
        }

        $output[$table] = sizeof($data[$json]);
    }



    return $output;

}




?>
