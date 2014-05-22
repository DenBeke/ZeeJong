<?php
/*
 File to create a new group
 */

namespace Controller {

    require_once (dirname(__FILE__) . '/../config.php');
    // Require config file containing configuration of the database
    require_once (dirname(__FILE__) . '/../database.php');
    // Require the database file
    require_once (dirname(__FILE__) . '/../classes/User.php');
    // We need the user class file
    require_once (dirname(__FILE__) . '/../functions.php');
    require_once (dirname(__FILE__) . '/Controller.php');

    class CreateGroup extends Controller {

        public $page = 'create-group';
        public $title;
        private $successMessage;

        /**
         * Constructor
         */
        public function __construct() {
            $this->theme = 'createGroup.php';
            $this->title = 'Create a Group - ' . Controller::siteName;
            if (!isset($_SESSION['userID'])) {
                return;
            }
            if (!isset($_POST['name'])) {
                return;
            }
            $this->addGroup();
        }

        private function addGroup(){
            $database = new \Database;
            $groupId = $database->addGroup($_POST['name'], $_SESSION['userID']);
            $database->addGroupMembership($_SESSION['userID'],$groupId);
            $database->acceptMembership($_SESSION['userID'],$groupId);
            $this -> successMessage = $this -> successMessage . "Successfully created group." . "\r\n";
        }

        public function getSuccessMessage(){
            return $this->successMessage;

        }


    }

}
?>
