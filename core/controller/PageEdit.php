<?php
/*
Error Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/../classes/Page.php');
require_once(dirname(__FILE__) . '/Controller.php');


    class PageEdit extends Controller {

        public $page;
        public $title;


        public function __construct() {
            $this->theme = 'page-edit.php';
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



        public function POST($args) {

            if(!isset($args[1])) {
                throw new \exception('No page id given');
                return;
            }

            if(!isset($_POST['title']) or !isset($_POST['content'])) {
                throw new exception("No title or content given");
            }

            global $database;
            $database->savePage($args[1], $_POST['title'], $_POST['content']);
            $this->page = $database->getPageById($args[1]);


        }


    }

}

?>
