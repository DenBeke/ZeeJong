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
    String function

    @return string
    */
    public function __toString() {
        $output = "ID: $this->id";
        return $output;
    }
}

?>