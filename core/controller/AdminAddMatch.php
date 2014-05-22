<?php
/*
Admin Single Match Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


    class AdminAddMatch extends Controller {

        public $page = 'admin-match';
        public $title;
        public $match;
        public $goals;
        public $cards;
        public $totalBet;

        public function __construct() {
            $this->theme = 'admin-match.php';
            $this->title = 'Admin - Match - ' . Controller::siteName;
        }


        /**
        Call GET methode with parameters

        @param params
        */
        public function GET($args) {
            $this->theme = 'error.php';

        }



        public function POST($args) {
            
            
            if(!isAdmin()) {
                return;
            }
            
            if(!isset($_POST['tournamentId'])) {
                echo 'No tournament id given';
                return;
            }
            
            if(!isset($_POST['teamAId'])) {
                echo 'No team a id given';
                return;
            }
            
            if(!isset($_POST['teamBId'])) {
                echo 'No team b id given';
                return;
            }
            
            if(!isset($_POST['date'])) {
                echo 'No date given';
                return;
            }
            
            if(!isset($_POST['finalType'])) {
                echo 'No final type given';
                return;
            }
            
            
            global $database;
            
            try {
            
                $id = $database->addMatch($_POST['teamAId'], $_POST['teamBId'], -1, -1, NULL, strtotime($_POST['date']), $_POST['tournamentId'], $_POST['finalType']);
                header('Location: ' . SITE_URL . 'admin/match/' . $id . '/edit');
            
            }
            catch (exception $e) {
                
                $this->theme = 'error.php';
                
            }
            
            
        }




    }

}

?>
