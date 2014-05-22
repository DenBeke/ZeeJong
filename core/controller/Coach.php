<?php
/*
Coach Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


    class Coach extends Controller {

        public $page = 'coach';
        public $coach;
        public $title;


        public function __construct() {
            $this->theme = 'coach.php';
            $this->title = 'Coach - ' . Controller::siteName;
        }


        /**
        Call GET methode with parameters

        @param params
        */
        public function GET($args) {

            if(!isset($args[1])) {
                throw new \exception('No coach id given');
                return;
            }

            global $database;
            $this->coach = $database->getCoachById($args[1]);

            $this->title = 'Coach - ' . $this->coach->getName() . ' - ' . Controller::siteName;
        }


    }

}

?>
