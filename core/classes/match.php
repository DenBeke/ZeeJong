<?php
/*
Match Class
*/



require_once(dirname(__FILE__) . '/Team.php');
require_once(dirname(__FILE__) . '/Score.php');
require_once(dirname(__FILE__) . '/Referee.php');
require_once(dirname(__FILE__) . '/Tournament.php');


/**
@brief Match Class

The class contains the following information:
- id
- date
- place
*/
class Match {
	private $id;
	private $date;
	private $place;

	/**
	Constructor
	@param id
	*/
	public function __construct($id) {
		$this->id = $id;
	}

	/**
	Get the ID of the match
	@return id
	*/
	public function getId() {
		return $this->id;
	}
	
	
	
	public function getTeamA() {
		return new Team(1);
	}
	
	
	public function getTeamB() {
		return new Team(1);
	}
	
	
	public function getScore() {
		return new Score;
	}
	
	
	public function getReferee() {
		return new Referee;
	}
	
	
	public function getTournament() {
		return new Tournament;
	}
	
	
	public function getDate() {
		return 0;
	}
	
	
	public function getPlayersTeamA() {
		return array();
	}
	
	public function getPlayersTeamB() {
		return array();
	}
	

	/**
	String function
	@return string
	*/
	public function __toString() {
		return "ID: $this->id";
	}

}
