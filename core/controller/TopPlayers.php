<?php
/*
Events Controller

Created March 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


	class TopPlayers extends Controller {

		public $page = 'players';
		public $players;

		public function __construct() {
			global $database;
			$this->theme = 'players.php';
			$this->players = $database->getPlayersWithMostMatches(0,30);
		}


		/**
		Call GET methode with parameters

		@param params
		*/
		public function GET($args) {
			global $database;

			$sel = new \Selector('Player');

			foreach($_GET as $column => $value) {
				switch($column) {
				case 'firstname':
				case 'lastname':
					if(strlen($value) < 3) {
						$this->players = [];
						return;
					}

					$value = str_replace('%', '\%', $value);
					$value = str_replace('[', '\[', $value);
					$value = str_replace(']', '\]', $value);
					$value = str_replace('_', '\_', $value);
					$value = '%' . $value . '%';
					$sel->filter([['Player.' . $column, 'LIKE', $value]]);

					break;

				case 'sort':
					if($value == 'match') {
						$sel->join('PlaysMatchInTeam', 'id', 'playerId');
						$sel->group('Player.id');
						$sel->select(['Player.*', 'COUNT(*) as playedMatches']);
						$sel->order('playedMatches', 'DESC');
					}
					break;
				}
			}

			print_r($sel->sql());

			$sel->limit(0, 10);

			$result = $database->select($sel);
			$this->players = $database->resultToPlayers($result);
		}


	}

}

?>
