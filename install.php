<html>
	<head>
		<title>Install script</title>
	</head>

	<body>
	<?php
	$tables = array(
'
CREATE TABLE IF NOT EXISTS `Coach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `country` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Coaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coachId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coachId` (`coachId`,`teamId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Competition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Fault` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `matchId` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `playerId` (`playerId`,`matchId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `matchId` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `playerId` (`playerId`,`matchId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamA` int(11) NOT NULL,
  `teamB` int(11) NOT NULL,
  `tournamentId` int(11) NOT NULL,
  `refereeId` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `scoreId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `teamA` (`teamA`,`teamB`),
  KEY `tournamentId` (`tournamentId`,`refereeId`),
  KEY `scoreId` (`scoreId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `country` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `PlaysIn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `playerId` (`playerId`,`teamId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `PlaysMatchInTeam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `matchId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `playerId` (`playerId`,`teamId`,`matchId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Referee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `countryId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `countryId` (`countryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamA` int(11) NOT NULL,
  `teamB` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `teamA` (`teamA`,`teamB`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `country` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Tournament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `competitionId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `competitionId` (`competitionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
'
	);

	function executeQuery($con, $query)
	{
		if(!mysqli_query($con, $query)) {
			resultOutput(mysqli_error($con));
			frontPage();
			return false;
		}

		return true;
	}

	function buildDatabase($host, $port, $database, $username, $password)
	{
		$con = mysqli_connect($host, $username, $password, $database, $port);
		if(!$con) {
			resultOutput('Could not connect to database: ' . mysqli_connect_error());
			frontPage();
			return;
		}

		global $tables;
		foreach($tables as $query) {
			if(!executeQuery($con, $query)) {
				return;
			}
		}
	}

	function start()
	{
		if(isset($_POST['submit'])) {
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
				resultOutput('Database not set');
				frontPage();
				return;
			} else {
				if($_POST['database'] == '') {
					resultOutput('Invalid database name');
					frontPage();
					return;
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
			resultOutput("Created database");
		} else {
			frontPage();
		}
	}

	function resultOutput($value)
	{
		echo "<p>$value</p>";
	}
	?>

	<?php
	function frontPage()
	{
	?>

	<form method="post">
		Host: <input type="text" name="host"></br>
		Port: <input type="text" name="port"></br>
		Database*: <input type="text" name="database"></br>
		Username: <input type="text" name="username"></br>
		Password: <input type="password" name="password"></br>
		<label>* Is required</label></br>
		<input type="submit" name="submit" value="submit">
	</form>

	<?php
	}
	?>

<?php
start();
?>

	</body>
</html>
