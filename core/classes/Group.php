<?php
require_once (dirname(__FILE__) . '/../database.php');

/**
 @brief Class containing a group

 The class contains the following information:
 -id
 -ownerID
 -name
 */

class Group {
    private $db;
    private $id;

    /**
     Constructor

     @param id The ID of the group
     */
    public function __construct($id, &$db) {
        $this -> db = &$db;
        $this -> id = $id;

    }

    /**
     Returns the id

     @return id
     */
    public function getId() {
        return $this -> id;
    }

    /**
     Returns the name

     @return the name
     */
    public function getName() {
        return $this -> db -> getGroupName($this -> id);
    }

    /**
     Returns whether I'm the owner of the group

     @param userID
     @return boolean indicating whether user is owner
     */
    public function isUserOwner($userId) {
        return $this -> db -> getGroupOwnerId($this -> id) == $userId;
    }

    /**
     Remove a user from the group

     @param the id of the user to remove
     */
    public function removeUser($userId) {
        return $this -> db -> removeUserFromGroup($userId, $this -> id);
    }

    /**
     Get the members of the group

     @return an array with the userId's
     */
    public function getMembers() {
        return $this -> db -> getGroupMembers($this -> id);
    }

    /**
     Get the bets of all users

     @return an array with the ID's of the bets of the users in the group
     */
    public function getBets() {
        $retAr = array();
        foreach ($this->getMembers() as $member) {
            $memberBets = $this -> db -> getUserBets($member);
            $retAr = array_merge($retAr, $memberBets);
        }
        return $retAr;
    }

    /**
     Get the handled bets of all users

     @return an array with the ID's of the handled bets of the users in the group
     */
    public function getHandledBets() {
        $retAr = array();
        foreach ($this->getMembers() as $member) {
            $memberBets = $this -> db -> getUserHandledBets($member);
            $retAr = array_merge($retAr, $memberBets);
        }
        return $retAr;
    }

    /**
     Get the unhandled bets of all users

     @return an array with the ID's of the unhandled bets of the users in the group
     */
    public function getUnhandledBets() {
        $retAr = array();
        foreach ($this->getMembers() as $member) {
            $memberBets = $this -> db -> getUserUnhandledBets($member);
            $retAr = array_merge($retAr, $memberBets);
        }
        return $retAr;
    }

    /**
     String function

     @return string
     */
    public function __toString() {
        $output = "ID: $this->id";
        return $output;
    }

}
?>