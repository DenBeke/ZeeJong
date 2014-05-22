<?php
/*
Player Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');
require_once(dirname(__FILE__) . '/../classes/Player.php');
require_once(dirname(__FILE__) . '/Error.php');
require_once(dirname(__FILE__) . '/../wiki/wiki.php');

    class Player extends Controller {

        public $player;
        public $teams;
        public $title;


        public function __construct() {
            $this->theme = 'player.php';
            $this->title = 'Player - ' . Controller::siteName;
        }


        /**
        Call GET methode with parameters

        @param params
        */
        public function GET($args) {
            if(!isset($args[1])) {
                throw new \exception('No player id given');
                return;
            }

            global $database;
            $this->player = $database->getPlayerById($args[1]);
            $this->teams = $database->getPlayerTeams($this->player->getId());

            $this->title = 'Player - ' . $this->player->getName() . ' - ' . Controller::siteName;
        }


        public function getWiki() {
            $wiki = new \Wiki;
            return $wiki->getPlayerWiki($this->player->getName());
        }


    }

}

?>
