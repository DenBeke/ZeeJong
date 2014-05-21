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

		$sel = new \Selector('Referee');

		$sort = false;
		$sortColumn = '';
		$sortOrder = '';

		foreach($_GET as $column => $value) {
			switch($column) {
			case 'id':
				$sel->filter([['Referee.id', '=', $value]]);
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
				$sel->filter([['Referee.' . $column, 'LIKE', $value]]);

				break;

			case 'sort':
				if($value == 'firstname') {
					$sort = true;
					$sortColumn = 'firstname';
				} else if($value == 'lastName') {
					$sort = true;
					$sortColumn = 'lastName';
				} else if($value == 'id') {
					$sort = true;
					$sortColumn = 'id';
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
					$filters[] = ['Referee.firstname','LIKE ', '%' . $term . '%'];
					$filters[] = ['Referee.lastname','LIKE ', '%' . $term . '%'];
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
		$this->result = $database->resultToReferees($result);
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
