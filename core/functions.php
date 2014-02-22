<?php
/*
General functions

Created: February 2014
*/


require_once(dirname(__FILE__) . '/database.php');


function getObject($pageName) {
	
	global $database;
	
	if($pageName == 'home') {
		return NULL;
	}
	elseif ($pageName == 'competition') {
		if(isset($_GET['competition'])) {
			$competitionId = intval(htmlspecialchars($_GET['competition']));
			return $database->getCompetitionById($competitionId);
		}
	}
	elseif ($pageName == 'tournament') {
		if(isset($_GET['tournament'])) {
			$tournamentId = intval(htmlspecialchars($_GET['tournament']));
			return $database->getTournamentById($tournamentId);
		}
	}
	elseif ($pageName == 'match') {
		if(isset($_GET['match'])) {
			$matchId = intval(htmlspecialchars($_GET['match']));
			return $database->getMatchById($matchId);
		}
	}
	elseif ($pageName == 'player') {
		if(isset($_GET['player'])) {
			$playerId = intval(htmlspecialchars($_GET['player']));
			return $database->getPlayerById($playerId);
		}
	}
	elseif ($pageName == 'coach') {
		if(isset($_GET['coach'])) {
			$coachId = intval(htmlspecialchars($_GET['coach']));
			return $database->getCoachById($coachId);
		}
	}
	elseif ($pageName == 'referee') {
		if(isset($_GET['referee'])) {
			$refereeId = intval(htmlspecialchars($_GET['referee']));
			return $database->getRefereeById($refereeId);
		}
	}
}


/**
Hash a password with a given salt
*/
function hashPassword($password,$salt) {
	return hash('sha256', $password . $salt);
}


?>