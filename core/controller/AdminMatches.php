<?php
/*
Admin Matches Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


    class AdminMatches extends Controller {

        public $page = 'admin-matches';
        public $coach;
        public $title;
        public $competitions;


        public function __construct() {
            $this->theme = 'admin-matches.php';
            $this->title = 'Admin - Matches - ' . Controller::siteName;

            global $database;
            $this->competitions = $database->getAllCompetitions();
        }

    }

}

?>
