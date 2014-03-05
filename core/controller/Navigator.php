<?php 
/*
Abstract controller class

Created: February 2014
*/

namespace Controller {


	require_once(dirname(__FILE__) . '/../config.php');

	class Navigator {
		
		
		/**
		Get the navigator to the given page
		
		@param controller
		@return array containing the title text and the link
		*/
		public function getNavigator(&$controller) {
		
			$nav = array();
			
			$nav['ZeeJong'] = SITE_URL;
			
			switch(get_class($controller)) {
			
				case 'Controller\Competition':
					$nav[$controller->competition->getName()] = SITE_URL . 'competition/' . $controller->competition->getId();
					break;
					
					
				case 'Controller\Tournament':
					$nav[$controller->tournament->getCompetition()->getName()] = SITE_URL . 'competition/' . $controller->tournament->getCompetition()->getId();
					$nav[$controller->tournament->getName()] = SITE_URL . 'tournament/' . $controller->tournament->getId();
					break;
					
				case 'Controller\Match':
					$nav[$controller->match->getTournament()->getCompetition()->getName()] = SITE_URL . 'competition/' . $controller->match->getTournament()->getCompetition()->getId();
					$nav[$controller->match->getTournament()->getName()] = SITE_URL . 'tournament/' . $controller->match->getTournament()->getId();
					$nav[$controller->match->getTeamA()->getName() . ' - ' .  $controller->match->getTeamB()->getName()] = SITE_URL . 'match/' . $controller->match->getId();
					break;
					
					
				case 'Controller\Player':
					$nav[$controller->player->getName()] = SITE_URL . 'player/' . $controller->player->getId();
					break;
					
				case 'Controller\Referee':
					$nav[$controller->referee->getName()] = SITE_URL . 'referee/' . $controller->referee->getId();
					break;
					
			
			}
		
		
			return $nav;
		
		}
		
		
	}

}
?>