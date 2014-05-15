<?php

require 'tables.php';
require 'config.php';

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
		$hostPost = trim($_POST['host']);
		if($hostPost != '') {
			$host = $hostPost;
		}
	}

	if(isset($_POST['port'])) {
		$portPost = trim($_POST['port']);
		if($portPost != '') {
			$port = $portPost;
		}
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
	
	if(!isset($_POST['adminUsername'])){
		throw new Exception('No admin username given');
	}
	if(!isset($_POST['adminEmail'])){
		throw new Exception('No admin email address given');
	}
	if(!isset($_POST['adminPassword'])){
		throw new Exception('No admin password given');
	}

	buildDatabase($host, (int)$port, $database, $username, $password);

	// Write config to directory
	$fh = fopen('../core/config.php', 'w');
	if($fh === false) {
		throw new Exception('Database was created but could not create config file');
	}

	fwrite($fh, "<?php\n");
	global $config;
	foreach($config as $key => $value) {
		fwrite($fh, "DEFINE('$key', $value);\n");
	}

	fwrite($fh, "DEFINE('DB_HOST', '$host');\n");
	fwrite($fh, "DEFINE('DB_PORT', $port);\n");
	fwrite($fh, "DEFINE('DB_USER', '$username');\n");
	fwrite($fh, "DEFINE('DB_PASS', '$password');\n");
	fwrite($fh, "DEFINE('DB_NAME', '$database');\n");

	fwrite($fh, '?>');
	fclose($fh);
	require_once (dirname(__FILE__) . '../../core/database.php');
	$database = new Database;
	$salt = uniqid(rand(0, 1000000));
	$hashedPassword = hash('sha256', $_POST['adminPassword'] . $salt);
	$id = $database->registerUser($_POST['adminUsername'], $salt, $hashedPassword, $_POST['adminEmail']);
	$database->makeAdmin($id);
}

?>
<!DOCTYPE html>
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
				echo '<p class="notice ok">The database was successfully initialized. Please remove the installation directory for security reasons.</p>';
			} catch(Exception $e) {
				echo '<p class="notice error">' . $e->getMessage() .  '</p>';
				include 'form.tpl.php';
			}
		}
		else {
			include 'form.tpl.php';
		}
	?>
	</div>

	</body>
</html>
