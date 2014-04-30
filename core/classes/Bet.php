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
	   Returns the score put on the first team
	    
	   @return score team A
	   */
	   public function getScoreA() {
	   	return $this->db->getScoreAFromBet($this->id);
	   }
	   
	   /**
	   Returns the score put on the second team
	    
	   @return score team B
	   */
	   public function getScoreB() {
	   	return $this->db->getScoreBFromBet($this->id);
	   }
	   
	   
	   /**
	   Returns the id of the player that will make the first goal
	    
	   @return id of player
	   */
	   public function getFirstGoal() {
	   	return $this->db->getFirstGoalFromBet($this->id);
	   }
	   
	   /**
	   Returns the red cards that will be handed this game
	    
	   @return # red cards
	   */
	   public function getRedCards() {
	   	return $this->db->getRedCardsFromBet($this->id);
	   }
	   
	   /**
	   Returns the yellow cards that will be handed this game
	    
	   @return # yellow cards
	   */
	   public function getYellowCards() {
	   	return $this->db->getYellowCardsFromBet($this->id);
	   }
	   
	   /**
	    Returns the amount of money the bet contains
	     
	    @return amount of money
	    */
	    public function getMoney() {
	    	return $this->db->getMoneyFromBet($this->id);
	    }
		
		/**
		 Returns the amount of items the user has bet on
		 @return an int telling on how many options the user has bet
		 */
		 public function howManyItemsBet(){
		 	$retVal=0;
			if($this->getScoreA()>=0){
				$retVal = $retVal +1;
			}
			if($this->getScoreB()>=0){
				$retVal = $retVal +1;
			}
			if($this->getFirstGoal()>=0){
				$retVal = $retVal +1;
			}
			if($this->getRedCards()>=0){
				$retVal = $retVal +1;
			}
			if($this->getYellowCards()>=0){
				$retVal = $retVal +1;
			}
			return $retVal;
		 }

	/**
	 Return the bet's data in string version for in a table row so it can be added easily to an existing table
	 @return the bet's data as a string
	 */
	 public function dataAsString(){
		$output = "";
		$output = $output."<td>".$this->db->getMatchById($this->getMatchId())->getTeamA()->getName()."</td>";
		$output = $output."<td><span class='badge'>";
		if($this->getScoreA()!=-1){
			$output = $output . $this->getScoreA() . " - ";
		}else{
			$output = $output . " / " . " - ";
		}
		if($this->getScoreB()!=-1){
			$output = $output . $this->getScoreB();
		}else{
			$output = $output . " / ";
		}
		$output = $output."</span></td>";
		$output = $output."<td>".$this->db->getMatchById($this->getMatchId())->getTeamB()->getName()."</td>";	
		$output = $output."<td>"."€ ".$this->getMoney()."</td>";
		
		
		
		
		return $output;
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