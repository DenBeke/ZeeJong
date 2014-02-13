<?php


/**
@brief Class containing referee data

The class contains the following information:
	-id
	-name
	-country
*/

class Referee {


	private $id;
	private $name;
	private $country;

	/**
	Constructor

	@param id The ID of the referee
	*/
	public function __construct($id) {

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