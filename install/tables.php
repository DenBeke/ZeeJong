<?php
$tables = array(
'
CREATE TABLE IF NOT EXISTS `Coach` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`firstname` varchar(50) NOT NULL,
`lastname` varchar(50) NOT NULL,
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
`matchId` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `coachId` (`coachId`,`teamId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Bet` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`matchId` int(11) NOT NULL,
`score1` int(2),
`score2` int(2),
`handled` BOOLEAN,
`userId` int(11) NOT NULL,
`amount` int(11) NOT NULL CHECK (amount>0),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Competition` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Cards` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`playerId` int(11) NOT NULL,
`matchId` int(11) NOT NULL,
`color` tinyint(1) NOT NULL,
`time` int(3) NOT NULL,
PRIMARY KEY (`id`),
KEY `playerId` (`playerId`,`matchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Goal` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`playerId` int(11) NOT NULL,
`matchId` int(11) NOT NULL,
`time` int(3) NOT NULL,
PRIMARY KEY (`id`),
KEY `playerId` (`playerId`,`matchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Match` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`teamA` int(11) NOT NULL,
`teamB` int(11) NOT NULL,
`tournamentId` int(11) NOT NULL,
`refereeId` int(11),
`date` int NOT NULL,
`scoreId` int(11),
PRIMARY KEY (`id`),
KEY `teamA` (`teamA`,`teamB`),
KEY `tournamentId` (`tournamentId`,`refereeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Player` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`firstname` varchar(50) NOT NULL,
`lastname` varchar(50) NOT NULL,
`country` int(11) NOT NULL,
`dateOfBirth` int,
`height` int(3),
`weight` int(3),
`position` varchar(50),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `PlaysIn` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`playerId` int(11) NOT NULL,
`teamId` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `playerId` (`playerId`,`teamId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `PlaysMatchInTeam` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`playerId` int(11) NOT NULL,
`number` int(11) NOT NULL,
`teamId` int(11) NOT NULL,
`matchId` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `playerId` (`playerId`,`teamId`,`matchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Referee` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`firstname` varchar(50) NOT NULL,
`lastname` varchar(50) NOT NULL,
`countryId` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `countryId` (`countryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Score` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`teamA` int(11),
`teamB` int(11),
PRIMARY KEY (`id`),
KEY `teamA` (`teamA`,`teamB`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Team` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`country` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `country` (`country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Tournament` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`competitionId` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `competitionId` (`competitionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',

'
CREATE TABLE IF NOT EXISTS `Country` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
',


'
CREATE TABLE IF NOT EXISTS `User` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(50) NOT NULL,
`password` varchar(128) NOT NULL,
`salt` varchar(128) NOT NULL,
`emailAddress` varchar(50) NOT NULL,
`money` FLOAT(11) DEFAULT "1000",
PRIMARY KEY (`id`)
) ENGINE=InnoDB ;
',

'
CREATE TABLE IF NOT EXISTS `Group`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(50) NOT NULL,
`ownerId` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB ;
',

'
CREATE TABLE IF NOT EXISTS `GroupMembership` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`userId` int(11) NOT NULL,
`groupId` int(11) NOT NULL,
`accepted` BOOLEAN,
PRIMARY KEY (`id`)
) ENGINE=InnoDB ;
',

'
CREATE TABLE IF NOT EXISTS `AlternativeUser` (
`id` varchar(255) NOT NULL,
`username` varchar(50) NOT NULL,
`emailAddress` varchar(50) NOT NULL,
`userId` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `userId` (`userId`)
) ENGINE=InnoDB CHARSET=utf8 ;
'
);

?>
