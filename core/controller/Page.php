<?php
/*
Error Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/../classes/Page.php');
require_once(dirname(__FILE__) . '/Controller.php');


    class Page extends Controller {

        public $page;
        public $title;


        public function __construct() {
            $this->theme = 'page.php';
            $this->title = 'Page - ' . Controller::siteName;
        }


        /**
        Call GET methode with parameters

        @param params
        */
        public function GET($args) {

            if(!isset($args[1])) {
                throw new \exception('No page id given');
                return;
            }


            global $database;
            $this->page = $database->getPageById($args[1]);


        }


    }

}

?>
