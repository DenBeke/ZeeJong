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

	[
		'json' => 'Countries',
		'db' => 'Country',
		'cols' => [
			'Id' => 'id',
			'Name' => 'name'
		]
	],
	
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
	]

];



//Add all json objects to the database

foreach ($schama as $meta) {
	$table = $meta['db'];
	$json = $meta['json'];
	
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




//Add countries


/*
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
*/

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