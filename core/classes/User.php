<?php
require_once (dirname(__FILE__) . '/../database.php');

/**
 @brief Class containing a user

 The class contains the following information:
 -id (key)
 -screenName (key)
 -firstName
 -lastName
 -phoneNr
 -streetName
 -houseNr
 -city
 -country
 -birthDate
 -gender
 -balans
 -joinDate
 -emailAddress
 -password (hashed)
 -avatar
 */

class User {
    private $d;
    private $id;
    private $screenName;
    private $firstName;
    private $lastName;
    private $phoneNr;
    private $streetName;
    private $houseNr;
    private $city;
    private $country;
    private $birthDate;
    private $gender;
    private $balans;
    private $joinDate;
    private $emailAddress;
    private $password;
    private $avatar;

    /**
     Constructor

     @param id The ID of the user
     */
    public function __construct($id) {
        $this -> id = $id;
        $this -> d = new Database;
    }

    /**
     Get the ID of the user

     @return the id of the user
     */
    public function getID() {
        return $this -> id;
    }

    /**player
     Get the username of the user

     @return the username of the user
     */
    public function getUserName() {
        return $this -> d -> getUserName($this -> id);
    }

    /**
     Get the hashed password of the user

     @return the hashed password of the user
     */
    public function getHash() {
        return $this -> d -> getUserPasswordHash($this -> id);
    }

    /**
     Get the salt of the user

     @return the salt password of the user
     */
    public function getSalt() {
        return $this -> d -> getUserPasswordSalt($this -> id);
    }

    /**
     Get the email address of the user

     @return the emailaddress
     */
    public function getMail() {
        return $this -> d -> getUserMail($this -> id);
    }

    /**
     Change the emailaddress of the user

     @param the new email address
     */
    public function setEmail($newMail) {
        return $this -> d -> setUserMail($this -> id, $newMail);
    }

    /**
     Change the hashed password of the user

     @param the new hashed password
     */
    public function setHash($newHash) {
        return $this -> d -> setUserHash($this -> id, $newHash);
    }

    /**
     Change the password salt of the user

     @param the new salt
     */
    public function setSalt($newSalt) {
        return $this -> d -> setUserSalt($this -> id, $newSalt);
    }

    /**
     Add money to the users' account

     @param the amount to add
     */
    public function addMoney($amount) {
        if ($amount > 0) {
            $newMoney = $this -> d -> getMoney($this -> id) + $amount;
            return $this -> d -> setMoney($this -> id, $newMoney);
        }
    }

    /**
     Add money to moneyWon
     @param the amount of money to add
     */
    public function addMoneyWon($amount) {
        if ($amount > 0) {
            $newMoney = $this -> d -> getMoneyWon($this -> id) + $amount;
            return $this -> d -> setMoneyWon($this -> id, $newMoney);
        }
    }

    /**
     Get the score of the user
     @return the score of the user
     */
     public function getScore(){
        $bets = $this->d->getUserHandledBets($this->id);
        $moneyBets=0;
        foreach($bets as $betId){
            $moneyBets = $moneyBets + $this->d->getMoneyFromBet($betId);
        }
        if($moneyBets==0){
            return 0;
        }
        return $this -> d -> getMoneyWon($this -> id)/$moneyBets;
     }

    /**
     Get the
     */

    /**
     Get the money the user has

     @return the money the user has
     */
    public function getMoney() {
        return $this -> d -> getMoney($this -> id);
    }

    /**
     Remove money from the users' account

     @param the amount to deduct
     */
    public function deductMoney($amount) {
        if ($amount > 0) {
            $newMoney = $this -> d -> getMoney($this -> id) - $amount;
            return $this -> d -> setMoney($this -> id, $newMoney);
        }
    }

}
?>