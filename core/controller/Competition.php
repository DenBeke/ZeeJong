<?php
/*
Competition Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


    class Competition extends Controller {

        public $page = 'competition';
        public $competition;
        public $title;


        public function __construct() {
            $this->theme = 'competition.php';
            $this->title = 'Competition - ' . Controller::siteName;
        }


        /**
        Call GET methode with parameters

        @param params
        */
        public function GET($args) {
            if(!isset($args[1])) {
                throw new \exception('Competition ID not given');
            }

            global $database;
            $this->competition = $database->getCompetitionById(intval($args[1]));

            $this->title = 'Competition - ' . $this->competition->getName() . ' - ' . Controller::siteName;
        }


    }

}

?>
