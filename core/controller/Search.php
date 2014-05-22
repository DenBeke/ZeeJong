<?php
/*
Search Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');


    class Search extends Controller {
        public $title;

        public function __construct() {
            $this->theme = 'search.php';
            $this->title = 'Search - ' . Controller::siteName;
        }


        /**
        Call GET methode with parameters

        @param params
        */
        public function GET($args) {
            global $database;

        }


    }

}

?>
