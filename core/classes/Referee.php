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
	Get the name of the referee
	@return full name
	*/
	public function getName() {
		// TODO: Get the name from somewhere

		return "";
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
