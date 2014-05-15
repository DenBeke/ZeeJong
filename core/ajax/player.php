<?php

require_once(dirname(__FILE__) . '/../database.php');
require_once(dirname(__FILE__) . '/../config.php');
require_once(dirname(__FILE__) . '/../Selector.php');
require_once(dirname(__FILE__) . '/../controller/Controller.php');

function addWildcards($s) {
	return '%' . $s . '%';
}

class Handler extends Controller\Controller {
	private $result = [];

	public function __construct() {
	}
	
	public function GET($args) {
		global $database;

		$sel = new \Selector('Player');

		$sort = false;
		$sortColumn = '';
		$sortOrder = '';

		foreach($_GET as $column => $value) {
			switch($column) {
			case 'id':
				$sel->filter([['Player.id', '=', $value]]);
				break;
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
					$sort = true;
					$sortColumn = 'playedMatches';
					$sel->join('PlaysMatchInTeam', 'id', 'playerId');
					$sel->group('Player.id');
					$sel->select(['Player.*', 'COUNT(*) as playedMatches']);
				}
				elseif($value == 'goal') {
					$sort = true;
					$sortColumn = 'goals';
					$sel->join('Goal', 'id', 'playerId');
					$sel->group('Player.id');
					$sel->select(['Player.*', 'COUNT(*) as goals']);
				}
				elseif($value == 'firstname') {
					$sort = true;
					$sortColumn = 'firstName';
				}
				break;

			case 'order':
				$sortOrder = $value;
				break;

			case 'search':
				$value = str_replace('%', '\%', $value);
				$value = str_replace('[', '\[', $value);
				$value = str_replace(']', '\]', $value);
				$value = str_replace('_', '\_', $value);

				$value = explode(' ', $value);
				$filters = [];
				foreach($value as $term) {
					$filters[] = ['Player.firstname','LIKE ', $term];
					$filters[] = ['Player.lastname','LIKE ', $term];
				}

				$sel->filter($filters);
				break;
			}
		}

		if($sort) {
			if($sortOrder === '') {
				$sel->order($sortColumn, 'DESC');
			}
			else {
				$sel->order($sortColumn, $sortOrder);
			}
		}
		
		$sel->limit(0, 10);

		$result = $database->select($sel);
		$this->result = $database->resultToPlayers($result);
	}

	public function template() {
		echo json_encode($this->result);
	}

}

$database = new Database;

$controller = new Handler;
$controller->GET(null);

$controller->template();

?>
