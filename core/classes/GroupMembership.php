<?php
require_once (dirname(__FILE__) . '/../database.php');

/**
@brief Class containing a groupMembership

The class contains the following information:
	-id 
	-userId
 	-groupId
 	-accepted
*/

class GroupMembership {
	private $db;
	private $id;

	/**
	Constructor

	@param id The ID of the groupMembership
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
	 Returns the name
	 
	 @return the name
	 */
	 public function getGroupName(){
	 	return $this->db->getGroupName($this->db->getGroupIdFromMembership($this->id));
	 }
	 
	 /**
	  Returns the name of who sent the invite
	  
	  @return the name of whoeever sent the invite
	 */
	 public function getSender(){
	 	return $this->db-> getUserName($this->db->getGroupOwnerId($this->db->getGroupIdFromMembership($this->id)));
	 }
	 
	 /**
	  Returns the user
	  
	  @return the userId
	  */
	  public function getUserId(){
	  	return $this->db->getUserIdFromMembership($this->id);
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