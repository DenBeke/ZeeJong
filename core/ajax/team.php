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

        $sel = new \Selector('Team');

        $sort = false;
        $sortColumn = '';
        $sortOrder = '';

        foreach($_GET as $column => $value) {
            switch($column) {
            case 'id':
                $sel->filter([['Team.id', '=', $value]]);
                break;
            case 'name':
                if(strlen($value) < 3) {
                    $this->result = [];
                    return;
                }

                $value = str_replace('%', '\%', $value);
                $value = str_replace('[', '\[', $value);
                $value = str_replace(']', '\]', $value);
                $value = str_replace('_', '\_', $value);
                $value = '%' . $value . '%';
                $sel->filter([['Team.' . $column, 'LIKE', $value]]);

                break;

            case 'sort':
                if($value == 'name') {
                    $sort = true;
                    $sortColumn = 'name';
                } elseif($value == 'id') {
                    $sort = true;
                    $sortColumn = 'id';
                }
                break;

            case 'order':
                $sortOrder = $value;
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
        $this->result = $database->resultToTeams($result);
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
