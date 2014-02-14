<?php

require 'tables.php';

function buildDatabase($host, $port, $database, $username, $password)
{
	$con = mysqli_connect($host, $username, $password, $database, $port);
	if(!$con) {
		throw new Exception('Could not connect to database: ' . mysqli_connect_error());
	}

	global $tables;
	foreach($tables as $query) {
		if(!mysqli_query($con, $query)) {
			throw new Exception('Could not execute query: ' . $con->error);
		}
	}
}

function handleSubmit()
{
	$host = '127.0.0.1';
	$port = '3306';
	$database = '';
	$username = '';
	$password = '';

	if(isset($_POST['host'])) {
		$database = trim($_POST['host']);
	}

	if(isset($_POST['port'])) {
		$port = trim($_POST['port']);
	}

	if(!isset($_POST['database'])) {
		throw new Exception('Database not given');
	} else {
		if($_POST['database'] == '') {
			throw new Exception('Invalid database name');
		}
		$database = trim($_POST['database']);
	}

	if(isset($_POST['username'])) {
		$username = trim($_POST['username']);
	}

	if(isset($_POST['password'])) {
		$password = trim($_POST['password']);
	}

	buildDatabase($host, (int)$port, $database, $username, $password);
}

?>

<html>
	<head>
		<title>Install script</title>
		
		<link href="style.css" rel="stylesheet" type="text/css">
		<link href="pure-min.css" rel="stylesheet" type="text/css">
	</head>

	<body>

	<div class="container">
	<h2>Install Soccer Management System</h2>
	<?php
		if(isset($_POST['submit'])) {
			try {
				handleSubmit();
				echo '<p>Created database</p>';
			} catch(Exception $e) {
				echo '<p>' . $e->getMessage() .  '</p>';
			}
		}

		include 'form.tpl.php';
	?>
	</div>

	</body>
</html>
