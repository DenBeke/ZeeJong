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



//Add countries
foreach ($data['Countries'] as $country) {
	$id = $country['Id'];
	$name = $country['Name'];
	echo  "<p>$id. $name</p>";
	
	
	if($id == 160) {
		echo "160!!!<br>";
	}
	
	$db->insert('Country', ['id', 'name'],
	[$id, $name]);
}

//Add players


//Add teams


//Add coaches


//Add referees


//Add competitions


//Add tournaments


//Add matches


//Add playsMatchInteam


//Add Coacheses


//Add playsIn


//Add referee for match


//Add goals


//Add cards

?>