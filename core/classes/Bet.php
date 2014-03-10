<?php
require_once (dirname(__FILE__) . '/../database.php');

/**
@brief Class containing a bet

The class contains the following information:
	-id 
 	-matchId
 	-teamId
 	-time
 	-userId
*/

class Bet {
	private $db;
	private $id;

	/**
	Constructor

	@param id The ID of the bet
	*/
	public function __construct($id, &$db) {
		$this->db = &$db;
		$this->id = $id;

	}

	/**
	Returns the id

	@return id
	*/
	public function getId() {
		return $this->id;
	}

	/**
	 Returns the Match ID
	 @return Match ID
	 */
	 public function getMatchId() {
	 	return $this->db->getMatchFromBet($this->id);
	 }
	 
	 /**
	  Returns the User ID
	  
	  @return User ID
	  */
	  public function getUserId() {
	  	return $this->db->getUserFromBet($this->id);
	  }
	  
	  /**
	   Returns the team the bet was put on
	    
	   @return Team ID
	   */
	   public function getTeamId() {
	   	return $this->db->getTeamFromBet($this->id);
	   }
	   
	   /**
	    Returns the amount of money the bet contains
	     
	    @return amount of money
	    */
	    public function getMoney() {
	    	return $this->db->getMoneyFromBet($this->id);
	    }

    /**
    String function

    @return string
    */
    public function __toString() {
        $output = "ID: $this->id";
        /*$output = $output . "$this->teamA";
        $output = $output . " - ";
        $output = $output . "$this->teamB";*/
        return $output;
    }
}

?>