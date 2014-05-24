<?php
$tables = array(
'
CREATE TABLE IF NOT EXISTS `Cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `matchId` int(11) NOT NULL,
  `color` tinyint(1) NOT NULL,
  `time` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `playerId_2` (`playerId`,`matchId`,`color`,`time`),
  KEY `playerId` (`playerId`,`matchId`),
  KEY `matchId` (`matchId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `Coach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `country` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `firstname` (`firstname`,`lastname`,`country`),
  KEY `country` (`country`),
  KEY `country_2` (`country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `Coaches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coachId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `matchId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coachId_3` (`coachId`,`teamId`,`matchId`),
  KEY `coachId` (`coachId`,`teamId`),
  KEY `coachId_2` (`coachId`),
  KEY `teamId` (`teamId`),
  KEY `matchId` (`matchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `Competition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `Country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `Goal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `matchId` int(11) NOT NULL,
  `time` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `playerId` (`playerId`,`matchId`),
  KEY `playerId_2` (`playerId`),
  KEY `matchId` (`matchId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,


'
CREATE TABLE IF NOT EXISTS `Match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamA` int(11) NOT NULL,
  `teamB` int(11) NOT NULL,
  `tournamentId` int(11) NOT NULL,
  `refereeId` int(11) DEFAULT NULL,
  `date` int(11) NOT NULL,
  `scoreId` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teamA_2` (`teamA`,`teamB`,`tournamentId`,`date`),
  KEY `teamA` (`teamA`,`teamB`),
  KEY `tournamentId` (`tournamentId`,`refereeId`),
  KEY `refereeId` (`refereeId`),
  KEY `scoreId` (`scoreId`),
  KEY `teamB` (`teamB`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `Player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `country` int(11) NOT NULL,
  `dateOfBirth` int(11) DEFAULT NULL,
  `height` int(3) DEFAULT NULL,
  `weight` int(3) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `firstname` (`firstname`,`lastname`,`country`,`dateOfBirth`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,


'
CREATE TABLE IF NOT EXISTS `PlaysIn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `playerId_3` (`playerId`,`teamId`),
  KEY `playerId` (`playerId`,`teamId`),
  KEY `playerId_2` (`playerId`),
  KEY `teamId` (`teamId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `PlaysMatchInTeam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playerId` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `matchId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `playerId_3` (`playerId`,`teamId`,`matchId`),
  KEY `playerId_2` (`playerId`),
  KEY `teamId` (`teamId`),
  KEY `matchId` (`matchId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `Referee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `countryId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `firstname` (`firstname`,`lastname`,`countryId`),
  KEY `countryId` (`countryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,


'
CREATE TABLE IF NOT EXISTS `Score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamA` int(11) DEFAULT NULL,
  `teamB` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teamA_2` (`teamA`,`teamB`),
  KEY `teamA` (`teamA`,`teamB`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,


'
CREATE TABLE IF NOT EXISTS `Team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `country` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`country`),
  KEY `country` (`country`),
  KEY `country_2` (`country`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `Tournament` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `competitionId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`competitionId`),
  KEY `competitionId` (`competitionId`),
  KEY `competitionId_2` (`competitionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `moneyWon` float DEFAULT 0,
  `money` float DEFAULT 1000,
  `admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `AlternativeUser` (
  `id` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,

'
CREATE TABLE IF NOT EXISTS `Bet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matchId` int(11) NOT NULL,
  `score1` int(2) DEFAULT NULL,
  `score2` int(2) DEFAULT NULL,
  `firstGoal` int(11) DEFAULT NULL,
  `yellowCards` int(3) DEFAULT NULL,
  `redCards` int(3) DEFAULT NULL,
  `handled` tinyint(1) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `matchId` (`matchId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
'
,


'
CREATE TABLE IF NOT EXISTS `Group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `ownerId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `name_2` (`name`,`ownerId`),
  KEY `ownerId` (`ownerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
'
,


'
CREATE TABLE IF NOT EXISTS `GroupMembership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `groupId` int(11) NOT NULL,
  `accepted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userId_2` (`userId`,`groupId`),
  KEY `userId` (`userId`,`groupId`),
  KEY `groupId` (`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
'
,


'
CREATE TABLE IF NOT EXISTS `Pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
'
,

'
ALTER TABLE `Cards`
  ADD CONSTRAINT `Cards_ibfk_2` FOREIGN KEY (`matchId`) REFERENCES `Match` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Cards_ibfk_1` FOREIGN KEY (`playerId`) REFERENCES `Player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
'
,

'
ALTER TABLE `Coach`
  ADD CONSTRAINT `Coach_ibfk_1` FOREIGN KEY (`country`) REFERENCES `Country` (`id`) ON UPDATE CASCADE;
'
,

'
ALTER TABLE `Coaches`
  ADD CONSTRAINT `Coaches_ibfk_3` FOREIGN KEY (`matchId`) REFERENCES `Match` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Coaches_ibfk_1` FOREIGN KEY (`coachId`) REFERENCES `Coach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Coaches_ibfk_2` FOREIGN KEY (`teamId`) REFERENCES `Team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
'
,

'
ALTER TABLE `Goal`
  ADD CONSTRAINT `Goal_ibfk_2` FOREIGN KEY (`matchId`) REFERENCES `Match` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Goal_ibfk_1` FOREIGN KEY (`playerId`) REFERENCES `Player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
'
,


'
ALTER TABLE `Match`
  ADD CONSTRAINT `Match_ibfk_5` FOREIGN KEY (`teamB`) REFERENCES `Team` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Match_ibfk_1` FOREIGN KEY (`teamA`) REFERENCES `Team` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Match_ibfk_2` FOREIGN KEY (`tournamentId`) REFERENCES `Tournament` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Match_ibfk_3` FOREIGN KEY (`refereeId`) REFERENCES `Referee` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `Match_ibfk_4` FOREIGN KEY (`scoreId`) REFERENCES `Score` (`id`);
'
,

'
ALTER TABLE `PlaysIn`
  ADD CONSTRAINT `PlaysIn_ibfk_2` FOREIGN KEY (`teamId`) REFERENCES `Team` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `PlaysIn_ibfk_1` FOREIGN KEY (`playerId`) REFERENCES `Player` (`id`) ON UPDATE CASCADE;
'
,

'
ALTER TABLE `Referee`
  ADD CONSTRAINT `Referee_ibfk_1` FOREIGN KEY (`countryId`) REFERENCES `Country` (`id`) ON UPDATE CASCADE;
'
,

'
ALTER TABLE `Team`
  ADD CONSTRAINT `Team_ibfk_1` FOREIGN KEY (`country`) REFERENCES `Country` (`id`) ON UPDATE CASCADE;
'
,

'
ALTER TABLE `Tournament`
  ADD CONSTRAINT `Tournament_ibfk_1` FOREIGN KEY (`competitionId`) REFERENCES `Competition` (`id`) ON UPDATE CASCADE;
'
,

'
ALTER TABLE `AlternativeUser`
  ADD CONSTRAINT `AlternativeUser_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
'
,

'
ALTER TABLE `GroupMembership`
  ADD CONSTRAINT `GroupMembership_ibfk_2` FOREIGN KEY (`groupId`) REFERENCES `Group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `GroupMembership_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `Player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
'
,

'
ALTER TABLE `Group`
  ADD CONSTRAINT `Group_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
'
,

'
ALTER TABLE `Bet`
  ADD CONSTRAINT `Bet_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Bet_ibfk_1` FOREIGN KEY (`matchId`) REFERENCES `Match` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
'

);

?>
